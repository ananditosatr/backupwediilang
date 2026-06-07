<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\URL;

class KasirController extends Controller
{
    public function loginForm()
    {
        if (Auth::check()) {
            return redirect()->route('kasir.dashboard');
        }
        return view('kasir.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $credentials['username'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            $user->update(['last_login' => now()]);
            return redirect()->route('kasir.dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput($request->only('username'));
    }

    public function dashboard()
    {
        $pendingReview = Order::where('status', 'pending_verification')
            ->with('items.menu')
            ->orderBy('created_at', 'desc')
            ->get();

        $processingOrders = Order::where('status', 'processing')
            ->with('items.menu')
            ->orderBy('created_at', 'asc')
            ->get();

        $readyOrders = Order::where('status', 'ready')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('kasir.dashboard', compact(
            'pendingReview',
            'processingOrders',
            'readyOrders'
        ));
    }

    public function approvePayment(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => 'processing']);

        return response()->json(['success' => true, 'message' => 'Pembayaran disetujui.']);
    }

    public function processCashPayment(Request $request, $orderId)
    {
        // Pembayaran tunai telah dinonaktifkan
        return response()->json([
            'success' => false,
            'message' => 'Pembayaran tunai sedang tidak tersedia.'
        ], 403);
    }

    public function rejectPayment(Request $request, $orderId)
    {
        $request->validate([
            'reason'      => 'required|string|max:255',
            'allow_retry' => 'boolean',
        ]);

        $order = Order::findOrFail($orderId);
        $order->update(['status' => 'cancelled']);

        return response()->json(['success' => true, 'message' => 'Pesanan ditolak dan dibatalkan.']);
    }

    public function updateStatus(Request $request, $orderId)
    {
        $validated = $request->validate([
            'status' => 'required|in:processing,ready,completed',
        ]);

        $order = Order::findOrFail($orderId);
        $order->update(['status' => $validated['status']]);

        return response()->json(['success' => true, 'message' => 'Status order diperbarui.']);
    }

    public function pollDashboard()
    {
        $pendingReview = Order::where('status', 'pending_verification')
            ->with(['items', 'payment'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn ($o) => [
                'id'           => $o->id,
                'order_number' => $o->order_number,
                'customer_name'=> $o->customer_name,
                'no_whatsapp'  => $o->no_whatsapp,
                'total_amount' => $o->total_amount,
                'items_count'  => $o->items->count(),
                'created_at'   => $o->created_at->diffForHumans(),
                'notes'        => $o->notes,
                'proof_image'  => $o->payment?->proof_image_base64,
                'order_method' => $o->order_method,
                'city'         => $o->city,
                'district'     => $o->district,
                'address'      => $o->address,
                'delivery_time'=> $o->delivery_time,
            ]);

        $processingOrders = Order::where('status', 'processing')
            ->with('items')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn ($o) => [
                'id'           => $o->id,
                'order_number' => $o->order_number,
                'customer_name'=> $o->customer_name,
                'no_whatsapp'  => $o->no_whatsapp,
                'total_amount' => $o->total_amount,
                'order_method' => $o->order_method,
                'city'         => $o->city,
                'district'     => $o->district,
                'address'      => $o->address,
                'delivery_time'=> $o->delivery_time,
            ]);

        $readyOrders = Order::where('status', 'ready')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn ($o) => [
                'id'           => $o->id,
                'order_number' => $o->order_number,
                'customer_name'=> $o->customer_name,
                'no_whatsapp'  => $o->no_whatsapp,
                'total_amount' => $o->total_amount,
                'order_method' => $o->order_method,
                'city'         => $o->city,
                'district'     => $o->district,
                'address'      => $o->address,
                'delivery_time'=> $o->delivery_time,
            ]);

        return response()->json([
            'pending_review'    => $pendingReview,
            'processing_orders' => $processingOrders,
            'ready_orders'      => $readyOrders,
        ]);
    }

    public function walkinForm()
    {
        $categories = Category::with(['menus' => function ($q) {
            $q->where('is_available', true)->where('stock', '>', 0)->orderBy('name');
        }])->where('status', 'active')->orderBy('name')->get();

        return view('kasir.walkin', compact('categories'));
    }

    public function walkinStore(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'notes'         => 'nullable|string',
            'items'         => 'required|array|min:1',
            'items.*.menu_id'  => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            $menuItems   = [];
            foreach ($validated['items'] as $item) {
                $menu         = Menu::findOrFail($item['menu_id']);
                $totalAmount += $menu->price * $item['quantity'];
                $menuItems[]  = ['menu' => $menu, 'quantity' => $item['quantity']];
            }

            $order = Order::create([
                'order_number'   => Order::generateOrderNumber(),
                'customer_name'  => $validated['customer_name'],
                'total_amount'   => $totalAmount,
                'status'         => 'processing',
                'payment_method' => 'walkin',
                'notes'          => $validated['notes'] ?? null,
            ]);

            foreach ($menuItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'menu_id'    => $item['menu']->id,
                    'quantity'   => $item['quantity'],
                    'unit_price' => $item['menu']->price,
                    'subtotal'   => $item['menu']->price * $item['quantity'],
                ]);
            }

            DB::commit();

            return redirect()->route('kasir.invoice', $order->order_number)
                ->with('success', 'Order walk-in berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Walk-in order failed', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Gagal membuat order. Silakan coba lagi.');
        }
    }

    public function invoice($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items.menu'])
            ->firstOrFail();

        return view('kasir.invoice', compact('order'))
            ->with('documentType', 'invoice');
    }

    public function deliveryNote($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items.menu'])
            ->firstOrFail();

        return view('kasir.invoice', compact('order'))
            ->with('documentType', 'surat_jalan');
    }

    public function printReceipt($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items.menu'])
            ->firstOrFail();

        return view('kasir.cetak_struk', compact('order'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('kasir.login');
    }

    // Password reset views and actions for kasir
    public function forgotForm()
    {
        return view('kasir.forgot');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        // Always respond with success message to avoid user enumeration
        if (! $user) {
            return back()->with('status', 'Jika akun tersedia, link reset password telah dibuat. Periksa instruksi.');
        }

        $token = Str::random(64);

        FacadesDB::table('password_resets')->insert([
            'username'   => $user->username,
            'token'      => $token,
            'created_at' => now(),
        ]);

        $resetUrl = URL::route('kasir.password.reset', ['token' => $token]) . '?username=' . urlencode($user->username);

        // Log reset link so developer can open it in VSCode (do not expose in UI)
        Log::info('Password reset link for kasir: ' . $resetUrl);

        return back()->with('status', 'Jika akun tersedia, link reset password telah dibuat. Periksa log pada storage/logs/laravel.log.');
    }

    public function showResetForm($token, Request $request)
    {
        $username = $request->query('username');
        return view('kasir.reset', compact('token', 'username'));
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'token'    => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $record = FacadesDB::table('password_resets')
            ->where('username', $validated['username'])
            ->where('token', $validated['token'])
            ->first();

        if (! $record) {
            return back()->withErrors(['token' => 'Token tidak valid atau sudah kadaluarsa.']);
        }

        // Optional: enforce expiration 60 minutes
        if (strtotime($record->created_at) < strtotime('-60 minutes')) {
            FacadesDB::table('password_resets')->where('username', $validated['username'])->delete();
            return back()->withErrors(['token' => 'Token sudah kadaluarsa. Silakan minta link baru.']);
        }

        $user = User::where('username', $validated['username'])->first();
        if (! $user) {
            return back()->withErrors(['username' => 'Akun tidak ditemukan.']);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        FacadesDB::table('password_resets')->where('username', $validated['username'])->delete();

        return redirect()->route('kasir.login')->with('success', 'Password berhasil direset. Silakan masuk.');
    }

    public function bayarTunai(Request $request, $id)
    {
        // Pembayaran tunai telah dinonaktifkan
        return back()->with('error', 'Pembayaran tunai sedang tidak tersedia.');
    }

    public function cetakStruk($id)
    {
        $order = Order::with('orderItems.menu')->findOrFail($id);
        return view('kasir.cetak_struk', compact('order'));
    }

}
