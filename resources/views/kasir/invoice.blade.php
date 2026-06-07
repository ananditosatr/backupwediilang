@extends('layouts.app')

@section('title')
Invoice {{ $order->order_number }} - Rumah Cake Suprezz
@endsection

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary-50 via-primary-100 to-primary-200 py-8 px-4">

    <!-- Action Bar (hidden on print) -->
    <div class="no-print max-w-lg mx-auto mb-4 flex items-center justify-between">
        <a href="{{ route('kasir.dashboard') }}"
            class="text-sm text-primary-700 hover:text-primary-900 transition">
            &larr; Dashboard
        </a>
        <div class="flex gap-2">
            <button onclick="window.print()"
                class="px-4 py-2 bg-primary-700 text-white rounded-lg text-sm font-medium hover:bg-primary-800 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Invoice Card -->
    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-lg overflow-hidden invoice-card">

        <!-- Header -->
        <div class="bg-gradient-to-br from-primary-600 to-primary-700 px-6 py-6 text-white text-center">
            <div class="flex justify-center mb-3">
                <img src="{{ asset('images/PT_rumah_cake_suprezz logo.png') }}" alt="Rumah Cake Suprezz" class="w-24 h-24 object-contain rounded-xl bg-white/20 p-2">
            </div>
            <h1 class="text-xl font-bold">Rumah Cake Suprezz</h1>
            <p class="text-primary-100 text-sm mt-0.5">
                @if(($documentType ?? 'invoice') === 'surat_jalan')
                    SURAT JALAN PESANAN
                @else
                    INVOICE PESANAN
                @endif
            </p>
        </div>

        <!-- Order Info -->
        <div class="px-6 py-5 border-b border-primary-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs text-primary-700">No. Order</p>
                    <p class="text-lg font-mono font-bold text-primary-900">{{ preg_replace('/-\d{3}$/', '', $order->order_number) }}</p>
                </div>
                <div class="text-right">
                    @php
                        $statusMap = [
                            'pending_payment'      => ['label' => 'Belum Bayar',   'class' => 'bg-gray-100 text-gray-600'],
                            'pending_verification' => ['label' => 'Verifikasi',     'class' => 'bg-primary-100 text-primary-700'],
                            'processing'           => ['label' => 'Diproses',       'class' => 'bg-primary-100 text-primary-700'],
                            'ready'                => ['label' => 'Siap Diambil',   'class' => 'bg-primary-100 text-primary-700'],
                            'completed'            => ['label' => 'Selesai',         'class' => 'bg-green-100 text-green-700'],
                            'cancelled'            => ['label' => 'Dibatalkan',     'class' => 'bg-red-100 text-red-700'],
                        ];
                        $sc = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'bg-gray-100 text-gray-600'];
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $sc['class'] }}">
                        {{ $sc['label'] }}
                    </span>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                <div>
                    <p class="text-xs text-primary-700">Pelanggan</p>
                    <p class="font-semibold text-primary-900">{{ $order->customer_name }}</p>
                    @if($order->no_whatsapp)
                    <p class="text-xs text-primary-700">WA: {{ $order->no_whatsapp }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-xs text-primary-700">Waktu Order</p>
                    <p class="font-semibold text-primary-900">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-primary-700">Metode Bayar</p>
                    <p class="font-semibold text-primary-900">
                        @switch($order->payment_method)
                            @case('walkin')
                                Tunai / Walk-in
                            @break
                            @case('qris')
                                QRIS
                            @break
                            @case('tunai')
                                Tunai
                            @break
                            @default
                                Transfer Bank
                        @endswitch
                    </p>
                </div>
                <div>
                    <p class="text-xs text-primary-700">Metode Order</p>
                    <p class="font-semibold text-primary-900">
                        @if($order->order_method === 'delivery')
                            Antar / Delivery
                        @else
                            Pickup
                        @endif
                    </p>
                </div>
                @if($order->order_method === 'delivery' && ($order->city || $order->district || $order->address))
                <div>
                    <p class="text-xs text-primary-700">Alamat Pengiriman</p>
                    <p class="font-semibold text-primary-900">
                        {{ trim(implode(', ', array_filter([$order->city, $order->district, $order->address]))) }}
                    </p>
                </div>
                @endif
                @if($order->delivery_time)
                <div>
                    <p class="text-xs text-primary-700">Waktu Antar</p>
                    <p class="font-semibold text-primary-900">{{ $order->delivery_time }}</p>
                </div>
                @endif
                @if(($documentType ?? 'invoice') === 'surat_jalan')
                <div>
                    <p class="text-xs text-primary-700">Kurir</p>
                    <p class="font-semibold text-primary-900">{{ config('kasir.courier_name', 'Satria') }}</p>
                    <p class="text-xs text-primary-700">Telepon Kurir</p>
                    <p class="font-semibold text-primary-900">{{ config('kasir.courier_phone', '08784493357') }}</p>
                </div>
                @endif
                @if($order->notes)
                <div>
                    <p class="text-xs text-primary-700">Catatan</p>
                    <p class="font-semibold text-primary-900">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Items -->
        <div class="px-6 py-4 border-b border-primary-200">
            <p class="text-xs font-semibold text-primary-800 uppercase tracking-wider mb-3">Detail Pesanan</p>
            <div class="space-y-2">
                @foreach($order->items as $item)
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-primary-900">{{ $item->menu->name ?? 'Menu dihapus' }}</p>
                        <p class="text-xs text-primary-700">{{ $item->quantity }}x &times; Rp {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                    </div>
                    <p class="text-sm font-bold text-primary-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Total -->
        <div class="px-6 py-4 border-b border-primary-200 bg-primary-50">
            <div class="flex justify-between items-center">
                <span class="font-bold text-primary-900">TOTAL BAYAR</span>
                <span class="text-2xl font-bold text-primary-700">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
            @if($order->payment_method === 'walkin')
            <p class="text-xs text-green-700 mt-1 font-medium">Lunas - Bayar Tunai</p>
            @endif
        </div>

        <!-- Footer -->
        <div class="px-6 py-5 text-center">
            <p class="text-xs text-primary-700 mb-3">
                Tunjukkan invoice ini saat mengambil pesanan
            </p>

            <p class="text-xs text-primary-700 mt-4">
                Rumah Cake Suprezz
            </p>
        </div>

    </div>

    @if(session('success'))
    <div class="no-print max-w-lg mx-auto mt-4 p-3 bg-green-50 border border-green-300 rounded-xl text-sm text-green-700 text-center">
        {{ session('success') }}
    </div>
    @endif

</div>

<style>
@media print {
    .no-print { display: none !important; }
    body { background: white !important; }
    .invoice-card {
        box-shadow: none !important;
        border-radius: 0 !important;
        max-width: 100% !important;
    }
}
</style>
@endsection
