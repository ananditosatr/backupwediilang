@extends('layouts.app')

@section('title', 'History Transaksi - POS Rumah Cake suprezz')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary-50 via-primary-100 to-primary-200">

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-primary-600 via-primary-500 to-primary-700 border-b border-primary-300/30 sticky top-0 z-40 shadow-sm">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/PT_rumah_cake_suprezz logo.png') }}" alt="PT Rumah Cake Suprezz" class="w-12 h-12 object-contain rounded-2xl bg-white/95 p-1 shadow-md">
                    <div>
                        <h1 class="text-base font-bold text-white">History Transaksi</h1>
                        <p class="text-xs text-primary-100">Riwayat semua pesanan</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('kasir.dashboard') }}"
                        class="text-sm text-primary-100 hover:text-white transition">
                        &larr; Dashboard
                    </a>
                    <form method="POST" action="{{ route('kasir.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-primary-200 font-medium">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
            <div class="bg-white/80 rounded-xl p-4 shadow-sm border-l-4 border-primary-500">
                <p class="text-xs text-primary-700">Total Order</p>
                <p class="text-2xl font-bold text-primary-900 mt-0.5">{{ $stats['total_orders'] }}</p>
            </div>
            <div class="bg-white/80 rounded-xl p-4 shadow-sm border-l-4 border-green-500">
                <p class="text-xs text-primary-700">Selesai</p>
                <p class="text-2xl font-bold text-green-700 mt-0.5">{{ $stats['completed'] }}</p>
            </div>
            <div class="bg-white/80 rounded-xl p-4 shadow-sm border-l-4 border-blue-500">
                <p class="text-xs text-primary-700">Diproses</p>
                <p class="text-2xl font-bold text-blue-700 mt-0.5">{{ $stats['processing'] }}</p>
            </div>
            <div class="bg-white/80 rounded-xl p-4 shadow-sm border-l-4 border-red-500">
                <p class="text-xs text-primary-700">Dibatalkan</p>
                <p class="text-2xl font-bold text-red-700 mt-0.5">{{ $stats['cancelled'] }}</p>
            </div>
        </div>

        <!-- Revenue and Trend Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl p-5 shadow">
                <p class="text-primary-100 text-sm font-medium mb-1">Total Pendapatan (Order Selesai)</p>
                <p class="text-3xl font-bold text-white">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                <p class="text-primary-200 text-xs mt-2">{{ $stats['period_label'] }} vs {{ $stats['previous_label'] }}</p>
                @php
                    $revenueUp = $stats['revenue_trend'] > 0;
                    $revenueSame = $stats['revenue_trend'] === 0;
                @endphp
                <div class="mt-4 inline-flex items-center gap-2 px-4 py-3 rounded-3xl bg-white/10 text-white text-sm">
                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-full {{ $revenueSame ? 'bg-white/20 text-white' : ($revenueUp ? 'bg-emerald-200 text-emerald-900' : 'bg-red-200 text-red-900') }}">
                        @if($revenueSame)
                            =
                        @elseif($revenueUp)
                            ↑
                        @else
                            ↓
                        @endif
                    </span>
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] opacity-80">Perubahan</p>
                        <p class="font-semibold">{{ $revenueUp ? 'Naik' : ($revenueSame ? 'Stabil' : 'Turun') }} {{ abs($stats['revenue_change_percent']) }}%</p>
                    </div>
                </div>
                <p class="text-primary-200 text-xs mt-3">Pendapatan sebelumnya: Rp {{ number_format($stats['previous_revenue'], 0, ',', '.') }}</p>
            </div>

            <div class="bg-white/80 rounded-xl p-5 shadow border border-primary-200">
                <p class="text-sm text-primary-700 font-medium mb-3">Ringkasan Penjualan</p>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-primary-600">Total Order</span>
                        <span class="font-semibold text-primary-900">{{ $stats['total_orders'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-primary-600">Rata-rata Order</span>
                        <span class="font-semibold text-primary-900">Rp {{ number_format($stats['average_order'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-primary-600">Dibatalkan</span>
                        <span class="font-semibold text-red-600">{{ $stats['cancelled'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-primary-600">Order vs {{ $stats['previous_label'] }}</span>
                        <span class="font-semibold {{ $stats['order_trend'] > 0 ? 'text-emerald-700' : ($stats['order_trend'] < 0 ? 'text-red-700' : 'text-primary-900') }}">
                            {{ $stats['order_trend'] > 0 ? 'Naik' : ($stats['order_trend'] < 0 ? 'Turun' : 'Stabil') }} {{ abs($stats['order_change_percent']) }}%
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 rounded-xl p-5 shadow border border-primary-200">
                <p class="text-sm text-primary-700 font-medium mb-3">Detail Laporan</p>
                <div class="space-y-4 text-primary-700 text-sm">
                    <div>
                        <p class="text-xs text-primary-500">Order Selesai</p>
                        <p class="font-semibold text-primary-900">{{ $stats['completed'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-primary-500">Diproses / Siap</p>
                        <p class="font-semibold text-primary-900">{{ $stats['processing'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-primary-500">Pendapatan naik/turun</p>
                        <p class="font-semibold {{ $revenueUp ? 'text-emerald-700' : ($revenueSame ? 'text-primary-900' : 'text-red-700') }}">
                            {{ $revenueUp ? 'Naik' : ($revenueSame ? 'Stabil' : 'Turun') }} {{ abs($stats['revenue_change_percent']) }}%
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-primary-500">Periode pembanding</p>
                        <p class="font-semibold text-primary-900">{{ $stats['previous_label'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="bg-white/80 rounded-xl shadow-sm p-4 mb-4 border border-primary-200/50">
            <form method="GET" action="{{ route('kasir.history') }}" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <label class="block text-xs font-medium text-primary-800 mb-1">Tanggal</label>
                    <input type="date" name="date"
                        value="{{ request('date', today()->format('Y-m-d')) }}"
                        class="w-full px-3 py-2 border border-primary-200 rounded-lg text-sm bg-white text-primary-900 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-medium text-primary-800 mb-1">Status</label>
                    <select name="status"
                        class="w-full px-3 py-2 border border-primary-200 rounded-lg text-sm bg-white text-primary-900 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="pending_payment"      {{ request('status') === 'pending_payment'      ? 'selected' : '' }}>Belum Bayar</option>
                        <option value="pending_verification" {{ request('status') === 'pending_verification' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="processing"           {{ request('status') === 'processing'           ? 'selected' : '' }}>Diproses</option>
                        <option value="ready"                {{ request('status') === 'ready'                ? 'selected' : '' }}>Siap Diambil</option>
                        <option value="completed"            {{ request('status') === 'completed'            ? 'selected' : '' }}>Selesai / Lunas</option>
                        <option value="cancelled"            {{ request('status') === 'cancelled'            ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="px-5 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium transition">
                        Filter
                    </button>
                    <a href="{{ route('kasir.history') }}"
                        class="px-4 py-2 bg-primary-100 text-primary-800 rounded-lg text-sm font-medium hover:bg-primary-200 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Trend and Export -->
        <div class="grid gap-4 mb-6 lg:grid-cols-1 max-w-[640px] mx-auto">
            <div class="bg-white/80 rounded-xl p-3 shadow border border-primary-200/50 w-full">
                <div class="flex flex-col gap-3 mb-4">
                    <div>
                        <p class="text-sm text-primary-700 font-medium">Grafik Tren 7 Hari</p>
                        <p class="text-xs text-primary-500">Pendapatan dan jumlah order</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 justify-start">
                        <button type="button" onclick="window.location.href='{{ route('kasir.history.export', request()->only(['date','status'])) }}'"
                            class="px-4 py-2 bg-primary-600 text-white rounded-lg text-xs font-semibold hover:bg-primary-700 transition">
                            Export CSV
                        </button>
                        <button type="button" onclick="window.print()"
                            class="px-4 py-2 bg-primary-100 text-primary-900 rounded-lg text-xs font-semibold hover:bg-primary-200 transition">
                            Cetak / PDF
                        </button>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="w-full overflow-hidden max-h-[170px]">
                        <p class="text-xs uppercase tracking-[0.24em] text-primary-500 mb-1.5">Pendapatan</p>
                        <div class="overflow-x-auto">
                            <div class="min-w-[520px]">
                                <canvas id="revenueChart" height="120" class="w-full max-w-[520px]"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="w-full overflow-hidden max-h-[170px]">
                        <p class="text-xs uppercase tracking-[0.24em] text-primary-500 mb-1.5">Order</p>
                        <div class="overflow-x-auto">
                            <div class="min-w-[520px]">
                                <canvas id="orderChart" height="120" class="w-full max-w-[520px]"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white/80 rounded-xl p-5 shadow border border-primary-200/50 w-full">
                <p class="text-sm font-medium text-primary-700 mb-4">Ringkasan Bulanan</p>
                <div class="space-y-4 text-primary-700">
                    <div class="bg-primary-50 rounded-2xl p-4">
                        <p class="text-xs text-primary-500">Pendapatan Bulan {{ $stats['current_month_label'] }}</p>
                        <p class="text-2xl font-bold text-primary-900">Rp {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}</p>
                        <p class="text-xs text-primary-500">Perbandingan dengan {{ $stats['previous_month_label'] }}: <span class="font-semibold {{ $stats['monthly_revenue_change'] >= 0 ? 'text-emerald-700' : 'text-red-700' }}">{{ $stats['monthly_revenue_change'] }}%</span></p>
                    </div>
                    <div class="bg-primary-50 rounded-2xl p-4">
                        <p class="text-xs text-primary-500">Order Bulan {{ $stats['current_month_label'] }}</p>
                        <p class="text-2xl font-bold text-primary-900">{{ $stats['monthly_orders'] }}</p>
                        <p class="text-xs text-primary-500">Perbandingan: <span class="font-semibold {{ $stats['monthly_order_change'] >= 0 ? 'text-emerald-700' : 'text-red-700' }}">{{ $stats['monthly_order_change'] }}%</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white/60 rounded-xl shadow-sm overflow-hidden border border-primary-200/50">
            <div class="px-5 py-3 border-b border-primary-200/50">
                <p class="text-sm font-medium text-primary-900">
                    {{ $orders->total() }} transaksi ditemukan
                </p>
            </div>

            @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-xs text-primary-800 border-b border-primary-200/50 bg-gradient-to-r from-primary-100/60 to-primary-200/60">
                            <th class="text-left px-5 py-3 font-medium">Order ID</th>
                            <th class="text-left px-3 py-3 font-medium">Customer</th>
                            <th class="text-left px-3 py-3 font-medium">Metode</th>
                            <th class="text-left px-3 py-3 font-medium">Item</th>
                            <th class="text-right px-3 py-3 font-medium">Total</th>
                            <th class="text-center px-3 py-3 font-medium">Status</th>
                            <th class="text-center px-3 py-3 font-medium">Pembayaran</th>
                            <th class="text-right px-3 py-3 font-medium">Waktu</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-primary-200/50">
                        @foreach($orders as $order)
                        <tr class="hover:bg-primary-50/50 transition cursor-pointer"
                            onclick="toggleDetail({{ $order->id }})">
                            <td class="px-5 py-3">
                                <span class="font-mono text-xs font-bold text-primary-900">{{ $order->order_number }}</span>
                            </td>
                            <td class="px-3 py-3 text-primary-800">{{ $order->customer_name }}</td>
                            <td class="px-3 py-3 text-primary-700">
                                @if($order->order_method === 'delivery')
                                    Antar
                                @else
                                    Pickup
                                @endif
                            </td>
                            <td class="px-3 py-3 text-primary-700">{{ $order->items->count() }} item</td>
                            <td class="px-3 py-3 text-right font-semibold text-primary-900 whitespace-nowrap">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-3 py-3 text-center">
                                @php
                                    $statusConfig = [
                                        'pending_payment'      => ['label' => 'Belum Bayar',   'class' => 'bg-gray-200 text-gray-700'],
                                        'pending_verification' => ['label' => 'Verifikasi',     'class' => 'bg-primary-100 text-primary-700'],
                                        'processing'           => ['label' => 'Diproses',       'class' => 'bg-primary-100 text-primary-700'],
                                        'ready'                => ['label' => 'Siap Ambil',     'class' => 'bg-primary-100 text-primary-700'],
                                        'completed'            => ['label' => 'Selesai',         'class' => 'bg-green-200 text-green-800'],
                                        'cancelled'            => ['label' => 'Dibatalkan',     'class' => 'bg-red-200 text-red-800'],
                                    ];
                                    $cfg = $statusConfig[$order->status] ?? ['label' => $order->status, 'class' => 'bg-gray-200 text-gray-700'];
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $cfg['class'] }}">
                                    {{ $cfg['label'] }}
                                </span>
                            </td>
                            <td class="px-3 py-3 text-center">
                                @if($order->status === 'completed' || $order->status === 'processing' || $order->status === 'ready')
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-200 text-green-800">
                                        Lunas
                                    </span>
                                @elseif($order->status === 'cancelled')
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-red-200 text-red-800">
                                        Batal
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-200 text-gray-700">
                                        Belum Lunas
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-3 text-right text-xs text-primary-700 whitespace-nowrap">
                                {{ $order->created_at->format('H:i') }}
                            </td>
                            <td class="px-5 py-3" onclick="event.stopPropagation()">
                                <a href="{{ route('kasir.invoice', $order->order_number) }}"
                                    class="px-2.5 py-1 bg-primary-100 text-primary-800 rounded-lg text-xs font-medium hover:bg-primary-200 transition whitespace-nowrap">
                                    Invoice
                                </a>
                            </td>
                        </tr>
                        <!-- Detail Row (hidden) -->
                        <tr id="detail-{{ $order->id }}" class="hidden bg-primary-50/30">
                            <td colspan="8" class="px-5 py-4">
                                <div class="text-xs text-primary-700">
                                    <p class="font-semibold text-primary-900 mb-2">Detail Pesanan:</p>
                                    <ul class="space-y-1 mb-3">
                                        @foreach($order->items as $item)
                                        <li class="flex justify-between max-w-sm">
                                            <span>{{ $item->quantity }}x {{ $item->menu->name ?? 'Menu dihapus' }}</span>
                                            <span class="font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @if($order->notes)
                                    <p class="italic text-primary-700">"{{ $order->notes }}"</p>
                                    @endif
                                    @if($order->order_method)
                                    <p class="mt-2"><strong>Metode:</strong> {{ ucfirst($order->order_method) }}</p>
                                    @endif
                                    @if($order->order_method === 'delivery' && ($order->city || $order->district || $order->address))
                                    <div class="mt-1 text-sm text-primary-700">
                                        <p><strong>Alamat:</strong> {{ trim(implode(', ', array_filter([$order->city, $order->district, $order->address]))) }}</p>
                                    </div>
                                    @endif
                                    @if($order->delivery_time)
                                    <p class="mt-1"><strong>Jam Pengiriman:</strong> {{ $order->delivery_time }}</p>
                                    @endif
                                    <p class="text-primary-700 mt-2">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
            <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $orders->links() }}
            </div>
            @endif

            @else
            <div class="py-12 text-center">
                <p class="text-gray-400 dark:text-gray-500 text-sm">Tidak ada transaksi ditemukan</p>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
@media print {
    body { background: white !important; color: #111827 !important; }
    nav, form, button, a, .no-print, .bg-primary-200, .bg-primary-100 { display: none !important; }
    .bg-white\/80 { background: white !important; }
    .shadow, .shadow-sm { box-shadow: none !important; }
    * { color: #111827 !important; }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
function toggleDetail(orderId) {
    const row = document.getElementById('detail-' + orderId);
    row.classList.toggle('hidden');
}

function renderHistoryCharts() {
    const labels = @json($stats['trend_labels']);
    const revenueData = @json($stats['trend_revenue']);
    const orderData = @json($stats['trend_orders']);

    const revenueCtx = document.getElementById('revenueChart');
    const orderCtx = document.getElementById('orderChart');

    if (revenueCtx) {
        const revenueMax = Math.max(...revenueData, 0);
        const revenueStep = revenueMax > 0 ? Math.ceil(revenueMax / 4 / 1000000) * 1000000 : 1000000;

        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan',
                    data: revenueData,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.18)',
                    fill: true,
                    tension: 0.35,
                    pointRadius: 4,
                    pointBackgroundColor: '#1d4ed8',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: revenueMax + revenueStep,
                        ticks: {
                            stepSize: revenueStep,
                            callback: value => 'Rp ' + value.toLocaleString('id-ID')
                        }
                    },
                    x: { ticks: { color: '#374151' } }
                }
            }
        });
    }

    if (orderCtx) {
        const orderMax = Math.max(...orderData, 0);
        const orderStep = orderMax > 0 ? Math.ceil(orderMax / 4) : 1;

        new Chart(orderCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Order',
                    data: orderData,
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: orderMax + orderStep,
                        ticks: {
                            stepSize: orderStep,
                            precision: 0
                        }
                    },
                    x: { ticks: { color: '#374151' } }
                }
            }
        });
    }
}

window.addEventListener('load', renderHistoryCharts);
</script>
@endpush
