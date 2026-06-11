<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function upload(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'proof_image' => 'required|image|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $order = Order::findOrFail($validated['order_id']);

            if (! in_array($order->status, ['pending_payment', 'pending_verification'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order tidak dalam status menunggu pembayaran.',
                ], 400);
            }

            if ($order->payment_deadline < now()) {
                $order->update(['status' => 'cancelled']);
                return response()->json([
                    'success' => false,
                    'message' => 'Waktu pembayaran telah habis.',
                ], 400);
            }

            $image = $request->file('proof_image');
            $imageData = base64_encode(file_get_contents($image->getRealPath()));
            $base64Image = 'data:' . $image->getMimeType() . ';base64,' . $imageData;

            $paymentData = [
                'proof_image_base64' => $base64Image,
                'status'             => 'uploaded',
                'uploaded_at'        => now(),
                'verified_at'        => null,
                'verified_by'        => null,
                'flagged_reason'     => null,
                'notes'              => null,
            ];

            if ($order->payment) {
                $order->payment->update($paymentData);
            } else {
                Payment::create(array_merge(['order_id' => $order->id], $paymentData));
            }

            $order->update(['status' => 'pending_verification']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Bukti pembayaran berhasil diupload.',
                'order' => $order->load('payment'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload bukti pembayaran.',
            ], 500);
        }
    }
}
