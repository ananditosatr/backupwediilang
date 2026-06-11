<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $selectedDate = $request->filled('date') ? Carbon::parse($request->date) : Carbon::today();
        $previousDate = $selectedDate->copy()->subDay();
        $currentMonthStart = $selectedDate->copy()->startOfMonth();
        $previousMonthStart = $currentMonthStart->copy()->subMonth();
        $previousMonthEnd = $previousMonthStart->copy()->endOfMonth();

        $query = Order::with(['items.menu', 'payment'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        $query->whereDate('created_at', $selectedDate->format('Y-m-d'));

        $orders = $query->paginate(20)->withQueryString();

        $statsQuery = Order::query()->whereDate('created_at', $selectedDate->format('Y-m-d'));
        $previousStatsQuery = Order::query()->whereDate('created_at', $previousDate->format('Y-m-d'));

        if ($request->filled('status')) {
            $statsQuery->where('status', $request->status);
            $previousStatsQuery->where('status', $request->status);
        }

        $currentRevenue = (clone $statsQuery)->where('status', 'completed')->sum('total_amount');
        $previousRevenue = (clone $previousStatsQuery)->where('status', 'completed')->sum('total_amount');
        $currentCompleted = (clone $statsQuery)->where('status', 'completed')->count();
        $currentOrders = $statsQuery->count();
        $previousOrders = $previousStatsQuery->count();

        $revenueChangePercent = $previousRevenue ? round((($currentRevenue - $previousRevenue) / $previousRevenue) * 100, 1) : ($currentRevenue ? 100 : 0);
        $orderChangePercent = $previousOrders ? round((($currentOrders - $previousOrders) / $previousOrders) * 100, 1) : ($currentOrders ? 100 : 0);

        $trendQuery = Order::query();
        if ($request->filled('status')) {
            $trendQuery->where('status', $request->status);
        }

        $trendStart = $selectedDate->copy()->subDays(6);
        $trendLabels = [];
        $trendRevenue = [];
        $trendOrders = [];
        for ($i = 0; $i < 7; $i++) {
            $day = $trendStart->copy()->addDays($i);
            $trendLabels[] = $day->format('d M');
            $trendRevenue[] = (clone $trendQuery)
                ->whereDate('created_at', $day->format('Y-m-d'))
                ->where('status', 'completed')
                ->sum('total_amount');
            $trendOrders[] = (clone $trendQuery)
                ->whereDate('created_at', $day->format('Y-m-d'))
                ->count();
        }

        $monthlyRevenueQuery = Order::query()->where('status', 'completed');
        $monthlyOrdersQuery = Order::query();
        $previousMonthlyQuery = Order::query()->where('status', 'completed');
        $previousMonthlyOrdersQuery = Order::query();
        if ($request->filled('status')) {
            $monthlyOrdersQuery->where('status', $request->status);
            $previousMonthlyOrdersQuery->where('status', $request->status);
            $monthlyRevenueQuery->where('status', $request->status);
            $previousMonthlyQuery->where('status', $request->status);
        }

        $monthlyRevenue = $monthlyRevenueQuery
            ->whereBetween('created_at', [$currentMonthStart, $selectedDate->copy()->endOfDay()])
            ->sum('total_amount');
        $previousMonthRevenue = $previousMonthlyQuery
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->sum('total_amount');
        $monthlyOrders = $monthlyOrdersQuery
            ->whereBetween('created_at', [$currentMonthStart, $selectedDate->copy()->endOfDay()])
            ->count();
        $previousMonthlyOrders = $previousMonthlyOrdersQuery
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->count();

        $monthlyRevenueChange = $previousMonthRevenue ? round((($monthlyRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100, 1) : ($monthlyRevenue ? 100 : 0);
        $monthlyOrderChange = $previousMonthlyOrders ? round((($monthlyOrders - $previousMonthlyOrders) / $previousMonthlyOrders) * 100, 1) : ($monthlyOrders ? 100 : 0);

        $stats = [
            'total_orders'      => $currentOrders,
            'completed'         => $currentCompleted,
            'processing'        => (clone $statsQuery)->whereIn('status', ['processing', 'ready'])->count(),
            'cancelled'         => (clone $statsQuery)->where('status', 'cancelled')->count(),
            'total_revenue'     => $currentRevenue,
            'average_order'     => $currentCompleted ? $currentRevenue / $currentCompleted : 0,
            'previous_revenue'  => $previousRevenue,
            'previous_orders'   => $previousOrders,
            'revenue_change'    => $currentRevenue - $previousRevenue,
            'order_change'      => $currentOrders - $previousOrders,
            'revenue_change_percent' => $revenueChangePercent,
            'order_change_percent'   => $orderChangePercent,
            'revenue_trend'     => $currentRevenue <=> $previousRevenue,
            'order_trend'       => $currentOrders <=> $previousOrders,
            'period_label'      => $selectedDate->isToday() ? 'Hari ini' : $selectedDate->format('d M Y'),
            'previous_label'    => $previousDate->format('d M Y'),
            'trend_labels'      => $trendLabels,
            'trend_revenue'     => $trendRevenue,
            'trend_orders'      => $trendOrders,
            'monthly_revenue'   => $monthlyRevenue,
            'monthly_orders'    => $monthlyOrders,
            'monthly_revenue_change' => $monthlyRevenueChange,
            'monthly_order_change'   => $monthlyOrderChange,
            'previous_month_label' => $previousMonthStart->format('M Y'),
            'current_month_label'  => $currentMonthStart->format('M Y'),
        ];

        return view('kasir.history', compact('orders', 'stats'));
    }

    public function export(Request $request)
    {
        $selectedDate = $request->filled('date') ? Carbon::parse($request->date) : Carbon::today();
        $query = Order::with('items')->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $query->whereDate('created_at', $selectedDate->format('Y-m-d'));
        $orders = $query->get();

        $filename = 'history_penjualan_' . $selectedDate->format('Ymd') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Order Number', 'Customer', 'Method', 'Status', 'Payment Status', 'Item Count', 'Total Amount', 'Created At']);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->customer_name,
                    $order->order_method === 'delivery' ? 'Antar' : 'Pickup',
                    $order->status,
                    in_array($order->status, ['completed', 'processing', 'ready']) ? 'Lunas' : ($order->status === 'cancelled' ? 'Batal' : 'Belum Lunas'),
                    $order->items->count(),
                    $order->total_amount,
                    $order->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
