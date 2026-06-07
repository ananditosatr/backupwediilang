@extends('layouts.app')

@section('title', 'Kasir Dashboard - POS Rumah Cake suprezz')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#FFF4EC] via-[#FFF1E6] to-[#FEF6ED] text-[#3F2B25]">

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-[#D9703E] via-[#FFAA64] to-[#C1542A] border-b border-[#D9703E]/30 sticky top-0 z-40 shadow-[0_20px_80px_rgba(217,112,62,0.25)] backdrop-blur-xl">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/PT_rumah_cake_suprezz logo.png') }}" alt="PT Rumah Cake Suprezz" class="w-12 h-12 object-contain rounded-2xl bg-white/95 p-1 shadow-md">
                    <div>
                        <h1 class="text-base font-bold text-white">Kasir Dashboard</h1>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <span id="live-dot" class="inline-block w-2 h-2 rounded-full bg-brand-soft transition-colors duration-300"></span>
                            <p class="text-xs text-brand-white/80">Live &bull; refresh 3 detik</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('kasir.history') }}"
                        class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 bg-brand-primary hover:bg-brand-primary-dark text-brand-white rounded-lg text-sm font-medium transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        History
                    </a>
                    <a href="{{ route('kasir.menu.index') }}"
                        class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 bg-brand-primary hover:bg-brand-primary-dark text-brand-white rounded-lg text-sm font-medium transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Kelola Menu
                    </a>
                    <a href="{{ route('customer.order') }}" target="_blank"
                        class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 bg-brand-soft hover:bg-[#F8B07A] text-[#3F2B25] rounded-lg text-sm font-medium transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Preview Menu
                    </a>
                    <button type="button" onclick="toggleDarkMode()" class="p-2 text-brand-white/90 hover:bg-white/20 rounded-lg transition">
                        <svg id="icon-moon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="icon-sun" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path>
                        </svg>
                    </button>

                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-medium text-brand-white">{{ Auth::user()->username }}</p>
                        <p class="text-xs text-brand-white/80">Kasir</p>
                    </div>

                    <form method="POST" action="{{ route('kasir.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-brand-soft hover:text-brand-white font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-brand-soft/30 rounded-3xl shadow-xl p-4 border border-brand-soft/40 backdrop-blur-sm">
                <p class="text-xs font-medium text-[#7A462F]">Pending Review</p>
                <h3 id="stat-pending" class="text-2xl font-bold text-[#A24423] mt-1">{{ $pendingReview->count() }}</h3>
            </div>
            <div class="bg-[#FFE8D8]/70 rounded-3xl shadow-xl p-4 border border-[#F4C2A3]/50 backdrop-blur-sm">
                <p class="text-xs font-medium text-[#7A462F]">Processing</p>
                <h3 id="stat-processing" class="text-2xl font-bold text-[#C1542A] mt-1">{{ $processingOrders->count() }}</h3>
            </div>
            <div class="bg-[#D9E8D7]/70 rounded-3xl shadow-xl p-4 border border-[#A8C9A9]/50 backdrop-blur-sm">
                <p class="text-xs font-medium text-[#7A462F]">Ready Pickup</p>
                <h3 id="stat-ready" class="text-2xl font-bold text-[#D9703E] mt-1">{{ $readyOrders->count() }}</h3>
            </div>
        </div>

        <!-- Pending Review Section -->
        <div class="bg-white/80 rounded-3xl backdrop-blur-sm shadow-2xl mb-6 border border-brand-soft/40">
            <div class="p-5 border-b border-brand-soft/40 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-[#3F2B25]">Antrian Review Pembayaran</h2>
                    <p class="text-xs text-[#6B4F3F] mt-0.5">Auto-refresh setiap 3 detik</p>
                </div>
            </div>
            <div id="pending-review-list" class="p-5 space-y-4">
                @forelse($pendingReview as $order)
                <div class="border border-brand-soft/40 rounded-3xl p-4 bg-white/90 backdrop-blur-sm shadow-xl">
                    <div class="grid gap-4 xl:grid-cols-[1.8fr_1fr]">
                        <div>
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-bold text-[#3F2B25]">{{ $order->order_number }}</span>
                                        <span class="px-2 py-0.5 bg-[#FDD7C0] text-[#A24423] rounded-full text-xs font-medium">Pending</span>
                                    </div>
                                    <p class="text-sm text-[#6B4F3F]">{{ $order->customer_name }}</p>
                                    @if($order->no_whatsapp)
                                    <p class="text-xs text-[#D9703E]">WA: {{ $order->no_whatsapp }}</p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-[#6B4F3F]">Total</p>
                                    <p class="text-xl font-bold text-[#D9703E]">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <div class="grid gap-2 sm:grid-cols-4 sm:gap-4 mb-4 text-xs text-[#6B4F3F]">
                                <span class="inline-flex items-center px-3 py-2 rounded-2xl bg-white/70 text-[#6B4F3F]">{{ $order->items->count() }} item</span>
                                <span class="inline-flex items-center px-3 py-2 rounded-2xl bg-white/70 text-[#6B4F3F]">{{ $order->created_at->diffForHumans() }}</span>
                                <span class="inline-flex items-center px-3 py-2 rounded-2xl bg-white/70 text-[#6B4F3F] capitalize">{{ $order->order_method === 'delivery' ? 'Delivery' : 'Pickup' }}</span>
                                @if($order->payment_method)
                                <span class="inline-flex items-center px-3 py-2 rounded-2xl bg-white/70 text-[#6B4F3F] capitalize">{{ $order->payment_method }}</span>
                                @endif
                            </div>

                            @if($order->order_method === 'delivery' && ($order->city || $order->district || $order->address))
                            <div class="rounded-2xl border border-[#F4C2A3] bg-[#FFFAF5] p-3 mb-4 text-sm text-[#3F2B25]">
                                <p class="font-semibold">Alamat Antar</p>
                                <p>{{ trim(implode(', ', array_filter([$order->city, $order->district, $order->address]))) }}</p>
                                @if($order->delivery_time)
                                <p class="mt-1 font-medium">Jam: {{ $order->delivery_time }}</p>
                                @endif
                            </div>
                            @endif

                            @if($order->notes)
                            <div class="rounded-2xl border border-brand-soft/40 bg-white/60 p-3 mb-4 text-sm text-[#5A453A] italic">
                                "{{ $order->notes }}"
                            </div>
                            @endif

                            <div class="flex flex-wrap justify-center items-center gap-2">
                                <button onclick="approvePayment({{ $order->id }})"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-[#D9703E] hover:bg-[#C1542A] text-white rounded-2xl text-sm font-semibold transition shadow-sm">
                                    ✓ Approve
                                </button>
                                <button onclick="rejectOrder({{ $order->id }})"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-brand-primary hover:bg-brand-primary-dark text-brand-white rounded-2xl text-sm font-semibold transition shadow-sm">
                                    ✕ Tolak
                                </button>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="rounded-3xl overflow-hidden border border-brand-soft/40 bg-white/70">
                                @if($order->proof_image)
                                <img src="{{ $order->proof_image }}" alt="Bukti Bayar" class="w-full h-48 object-cover cursor-pointer" onclick="viewProof('{{ $order->proof_image }}')">
                                @else
                                <div class="w-full h-48 flex items-center justify-center text-[#6B4F3F] text-sm">Belum ada bukti pembayaran</div>
                                @endif
                            </div>
                            <div class="px-3 py-2 rounded-3xl border border-brand-soft/40 bg-white/70 text-xs text-[#6B4F3F]">
                                Klik gambar untuk lihat bukti pembayaran.
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-center text-[#6B4F3F] py-8 text-sm">Tidak ada order yang perlu direview</p>
                @endforelse
            </div>
        </div>

        <!-- Order Status Management -->
        <div class="bg-white/80 rounded-3xl backdrop-blur-sm shadow-2xl border border-brand-soft/40">
            <div class="p-5 border-b border-brand-soft/40">
                <h2 class="text-base font-bold text-[#3F2B25]">Manajemen Status Order</h2>
            </div>
            <div id="order-management-list" class="p-5 space-y-4">
                @if($processingOrders->isEmpty() && $readyOrders->isEmpty())
                <p class="text-center text-[#6B4F3F] text-sm py-6">Tidak ada order aktif saat ini.</p>
                @endif

                @foreach($processingOrders as $order)
                <div class="border border-brand-soft/40 rounded-3xl p-4 bg-white/90 backdrop-blur-sm shadow-xl">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-semibold text-[#3F2B25]">{{ $order->order_number }}</span>
                                <span class="px-2 py-0.5 bg-[#FFE8D8] text-[#C1542A] rounded-full text-xs">Diproses</span>
                            </div>
                            <p class="text-xs text-[#6B4F3F]">{{ $order->customer_name }}@if($order->no_whatsapp) &bull; WA: {{ $order->no_whatsapp }}@endif</p>
                            <p class="text-xs text-[#6B4F3F] mt-2">Metode: {{ $order->order_method === 'delivery' ? 'Antar' : 'Pickup' }}</p>
                            @if($order->order_method === 'delivery' && ($order->city || $order->district || $order->address))
                            <p class="text-xs text-[#6B4F3F]">Alamat: {{ trim(implode(', ', array_filter([$order->city, $order->district, $order->address]))) }}</p>
                            @endif
                            @if($order->delivery_time)
                            <p class="text-xs text-[#6B4F3F]">Jam: {{ $order->delivery_time }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-3 flex-wrap">
                            <p class="text-sm font-semibold text-[#D9703E]">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            @if($order->order_method === 'delivery')
                            <a href="{{ route('kasir.delivery.note', $order->order_number) }}" target="_blank"
                                class="px-4 py-2 bg-[#E2E8F0] hover:bg-[#CBD5E1] text-[#1F2937] rounded-2xl text-sm font-semibold transition shadow-sm">
                                Surat Jalan
                            </a>
                            @endif
                            <a href="{{ route('kasir.invoice', $order->order_number) }}" target="_blank"
                                class="px-4 py-2 bg-[#F4E1D8] hover:bg-[#E6C9B6] text-[#3F2B25] rounded-2xl text-sm font-semibold transition shadow-sm">
                                Invoice
                            </a>
                            <button onclick="updateStatus({{ $order->id }}, 'ready')"
                                class="px-4 py-2 bg-[#D9703E] hover:bg-[#C1542A] text-white rounded-2xl text-sm font-semibold transition shadow-sm">
                                Siap
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach

                @foreach($readyOrders as $order)
                <div class="border border-brand-soft/40 rounded-3xl p-4 bg-white/90 shadow-xl backdrop-blur-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-semibold text-[#3F2B25]">{{ $order->order_number }}</span>
                                <span class="px-2 py-0.5 bg-[#D9E8D7] text-[#D9703E] rounded-full text-xs">Siap Diambil</span>
                            </div>
                            <p class="text-xs text-[#6B4F3F]">{{ $order->customer_name }}@if($order->no_whatsapp) &bull; WA: {{ $order->no_whatsapp }}@endif</p>
                            <p class="text-xs text-[#6B4F3F] mt-2">Metode: {{ $order->order_method === 'delivery' ? 'Antar' : 'Pickup' }}</p>
                            @if($order->order_method === 'delivery' && ($order->city || $order->district || $order->address))
                            <p class="text-xs text-[#6B4F3F]">Alamat: {{ trim(implode(', ', array_filter([$order->city, $order->district, $order->address]))) }}</p>
                            @endif
                            @if($order->delivery_time)
                            <p class="text-xs text-[#6B4F3F]">Jam: {{ $order->delivery_time }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-3 flex-wrap">
                            <p class="text-sm font-semibold text-[#D9703E]">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            @if($order->order_method === 'delivery')
                            <a href="{{ route('kasir.delivery.note', $order->order_number) }}" target="_blank"
                                class="px-4 py-2 bg-[#E2E8F0] hover:bg-[#CBD5E1] text-[#1F2937] rounded-2xl text-sm font-semibold transition shadow-sm">
                                Surat Jalan
                            </a>
                            @endif
                            <a href="{{ route('kasir.invoice', $order->order_number) }}" target="_blank"
                                class="px-4 py-2 bg-[#F4E1D8] hover:bg-[#E6C9B6] text-[#3F2B25] rounded-2xl text-sm font-semibold transition shadow-sm">
                                Invoice
                            </a>
                            <button onclick="updateStatus({{ $order->id }}, 'completed')"
                                class="px-4 py-2 bg-brand-primary hover:bg-brand-primary-dark text-brand-white rounded-2xl text-sm font-semibold transition shadow-sm">
                                Selesai
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

<!-- Proof Image Modal -->
<div id="proof-modal" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 pointer-events-none" onclick="closeProofModal()">
    <div class="pointer-events-auto bg-white dark:bg-[#3B2A22] rounded-xl max-w-lg w-full p-5" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-[#3F2B25] dark:text-brand-soft">Bukti Pembayaran</h3>
            <button onclick="closeProofModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <img id="proof-img" src="" alt="Bukti Bayar" class="w-full rounded-lg">
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="hidden fixed top-4 right-4 z-50 px-5 py-3 rounded-lg shadow-lg text-white text-sm font-medium"></div>
@endsection

@push('scripts')
<script>
function toggleDarkMode() {
    const html = document.documentElement;
    const isDark = html.classList.contains('dark');
    if (isDark) {
        html.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    } else {
        html.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    }
    updateDarkModeIcons();
}

function updateDarkModeIcons() {
    const isDark = document.documentElement.classList.contains('dark');
    document.getElementById('icon-moon').classList.toggle('hidden', isDark);
    document.getElementById('icon-sun').classList.toggle('hidden', !isDark);
}

if (document.readyState !== 'loading') {
    updateDarkModeIcons();
}

document.addEventListener('DOMContentLoaded', function() {
    updateDarkModeIcons();
});

function viewProof(imageBase64) {
    document.getElementById('proof-img').src = imageBase64;
    document.getElementById('proof-modal').classList.remove('hidden');
}

function closeProofModal() {
    document.getElementById('proof-modal').classList.add('hidden');
}

function approvePayment(orderId) {
    Swal.fire({
        title: 'Approve Pembayaran?',
        text: 'Pembayaran akan disetujui dan pesanan diproses.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Approve',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#6b7280',
    }).then(result => {
        if (!result.isConfirmed) return;
        fetch(`/kasir/orders/${orderId}/approve`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken() }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('success', data.message);
                setTimeout(() => location.reload(), 1200);
            } else {
                showToast('error', data.message);
            }
        });
    });
}

function rejectOrder(orderId) {
    Swal.fire({
        title: 'Tolak Pesanan?',
        text: 'Pesanan akan dibatalkan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Tolak',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
    }).then(result => {
        if (!result.isConfirmed) return;
        fetch(`/kasir/orders/${orderId}/reject`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken() },
            body: JSON.stringify({ reason: 'Ditolak kasir', allow_retry: false })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('success', data.message);
                setTimeout(() => location.reload(), 1200);
            } else {
                showToast('error', data.message);
            }
        });
    });
}

function cashPayment(orderId) {
    // Pembayaran tunai telah dinonaktifkan
    showToast('warning', 'Pembayaran tunai sedang tidak tersedia.');
    return false;
}

function updateStatus(orderId, newStatus) {
    const label = newStatus === 'ready' ? 'Siap Diambil' : 'Selesai';
    Swal.fire({
        title: `Update ke "${label}"?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Update',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
    }).then(result => {
        if (!result.isConfirmed) return;
        fetch(`/kasir/orders/${orderId}/update-status`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken() },
            body: JSON.stringify({ status: newStatus })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('success', data.message);
                setTimeout(() => location.reload(), 1200);
            }
        });
    });
}

function showToast(type, message) {
    const colors = { success: 'bg-[#D9703E]', error: 'bg-brand-primary', warning: 'bg-brand-soft' };
    const toast = document.getElementById('toast');
    toast.className = `fixed top-4 right-4 z-50 px-5 py-3 rounded-lg shadow-lg text-white text-sm font-medium ${colors[type]}`;
    toast.textContent = message;
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 3000);
}

function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]').content;
}

@if(session('cash_receipt_order'))
window.addEventListener('load', function() {
    const receiptUrl = '{{ route('kasir.print.receipt', session('cash_receipt_order')) }}';
    window.open(receiptUrl, '_blank');
});
@endif

// ── Live Polling ──────────────────────────────────────────────
const POLL_URL = '{{ route("kasir.dashboard.poll") }}';
let lastPendingCount = {{ $pendingReview->count() }};

function formatRupiah(n) {
    return 'Rp ' + Number(n).toLocaleString('id-ID');
}
function renderPendingReview(orders) {
    const wrap = document.getElementById('pending-review-list');
    const badge = document.getElementById('stat-pending');
    if (badge) badge.textContent = orders.length;

    if (orders.length === 0) {
        wrap.innerHTML = '<p class="text-center text-[#6B4F3F] py-8 text-sm">Tidak ada order yang perlu direview</p>';
        return;
    }

    wrap.innerHTML = orders.map(o => {
        return `
        <div class="border border-brand-soft/40 rounded-3xl p-4 mb-4 bg-white/80 shadow-xl backdrop-blur-sm">
            <div class="grid gap-4 xl:grid-cols-[1.8fr_1fr]">
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-bold text-[#3F2B25] text-base">${o.order_number}</span>
                                <span class="px-2 py-0.5 bg-[#FDD7C0] text-[#A24423] rounded-full text-xs font-medium">Pending</span>
                            </div>
                            <p class="text-sm text-[#3F2B25]">${o.customer_name}</p>
                            ${o.no_whatsapp ? `<p class="text-xs text-[#D9703E]">WA: ${o.no_whatsapp}</p>` : ''}
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-[#6B4F3F]">Total</p>
                            <p class="text-xl font-bold text-[#D9703E]">${formatRupiah(o.total_amount)}</p>
                        </div>
                    </div>

                    <div class="grid gap-2 sm:grid-cols-3 sm:gap-4 mb-4 text-xs text-[#3F2B25]">
                        <span class="inline-flex items-center px-3 py-2 rounded-2xl bg-white/20 text-[#3F2B25]">${o.items_count} item</span>
                        <span class="inline-flex items-center px-3 py-2 rounded-2xl bg-white/20 text-[#3F2B25]">${o.created_at}</span>
                        <span class="inline-flex items-center px-3 py-2 rounded-2xl bg-white/20 text-[#3F2B25] capitalize">${o.order_method === 'delivery' ? 'Delivery' : 'Pickup'}</span>
                        ${o.payment_method ? `<span class="inline-flex items-center px-3 py-2 rounded-2xl bg-white/20 text-[#3F2B25] capitalize">${o.payment_method}</span>` : ''}
                    </div>

                    ${o.order_method === 'delivery' && (o.city || o.district || o.address) ? `
                    <div class="rounded-2xl border border-[#F4C2A3] bg-[#FFFAF5] p-3 mb-4 text-sm text-[#3F2B25]">
                        <p class="font-semibold">Alamat Antar</p>
                        <p>${[o.city, o.district, o.address].filter(Boolean).join(', ')}</p>
                        ${o.delivery_time ? `<p class="mt-1 font-medium">Jam: ${o.delivery_time}</p>` : ''}
                    </div>
                    ` : ''}

                    ${o.notes ? `<div class="rounded-2xl border border-brand-soft/40 bg-white/70 p-3 mb-4 text-sm text-[#5A453A] italic">"${o.notes}"</div>` : ''}

                    <div class="flex flex-wrap justify-center items-center gap-2">
                        <button type="button" onclick="approvePayment('${o.id}')"
                            class="inline-flex items-center justify-center px-4 py-2 bg-[#D9703E] hover:bg-[#C1542A] text-white rounded-2xl text-sm font-semibold transition shadow-sm">
                            ✓ Approve
                        </button>
                        <button type="button" onclick="rejectOrder('${o.id}')"
                            class="inline-flex items-center justify-center px-4 py-2 bg-brand-primary hover:bg-brand-primary-dark text-brand-white rounded-2xl text-sm font-semibold transition shadow-sm">
                            ✕ Tolak
                        </button>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="rounded-3xl overflow-hidden border border-brand-soft/40 bg-white/70">
                        ${o.proof_image
                            ? `<img src="${o.proof_image}" alt="Bukti Bayar" class="w-full h-48 object-cover cursor-pointer" onclick="viewProof('${o.proof_image}')">`
                            : `<div class="w-full h-48 flex items-center justify-center text-[#6B4F3F] text-sm">Belum ada bukti pembayaran</div>`
                        }
                    </div>
                    <div class="px-3 py-2 rounded-3xl border border-brand-soft/40 bg-white/70 text-xs text-[#6B4F3F]">
                        Klik gambar untuk melihat bukti pembayaran.
                    </div>
                </div>
            </div>
        </div>
        `;
    }).join('');
}

function renderOrderManagement(processing, ready) {
    const wrap = document.getElementById('order-management-list');
    const statProcessing = document.getElementById('stat-processing');
    const statReady = document.getElementById('stat-ready');
    if (statProcessing) statProcessing.textContent = processing.length;
    if (statReady) statReady.textContent = ready.length;

    let html = '';

    if (processing.length === 0 && ready.length === 0) {
        html = '<p class="text-center text-[#6B4F3F] text-sm py-6">Tidak ada order aktif</p>';
    }

    html += processing.map(o => `
        <div class="border border-brand-soft/40 rounded-3xl p-4 mb-4 bg-white/80 shadow-xl backdrop-blur-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-semibold text-[#3F2B25]">${o.order_number}</span>
                        <span class="px-2 py-0.5 bg-[#FFE8D8] text-[#C1542A] rounded-full text-xs">Diproses</span>
                    </div>
                    <p class="text-xs text-[#3F2B25]">${o.customer_name}${o.no_whatsapp ? ` &bull; WA: ${o.no_whatsapp}` : ''}</p>
                    <p class="text-xs text-[#3F2B25] mt-2">Metode: ${o.order_method === 'delivery' ? 'Antar' : 'Pickup'}</p>
                    ${o.order_method === 'delivery' && (o.city || o.district || o.address) ? `<p class="text-xs text-[#3F2B25]">Alamat: ${[o.city, o.district, o.address].filter(Boolean).join(', ')}</p>` : ''}
                    ${o.delivery_time ? `<p class="text-xs text-[#3F2B25]">Jam: ${o.delivery_time}</p>` : ''}
                </div>
                <div class="flex items-center gap-3 flex-wrap">
                    <p class="text-sm font-semibold text-[#D9703E]">${formatRupiah(o.total_amount)}</p>
                    ${o.order_method === 'delivery' ? `
                    <a href="/kasir/delivery-note/${o.order_number}" target="_blank"
                        class="px-4 py-2 bg-[#E2E8F0] hover:bg-[#CBD5E1] text-[#1F2937] rounded-2xl text-sm font-semibold transition shadow-sm">
                        Surat Jalan
                    </a>
                    ` : ''}
                    <a href="/kasir/invoice/${o.order_number}" target="_blank"
                        class="px-4 py-2 bg-[#F4E1D8] hover:bg-[#E6C9B6] text-[#3F2B25] rounded-2xl text-sm font-semibold transition shadow-sm">
                        Invoice
                    </a>
                    <button onclick="updateStatus(${o.id}, 'ready')"
                        class="px-4 py-2 bg-[#D9703E] hover:bg-[#C1542A] text-white rounded-2xl text-sm font-semibold transition shadow-sm">
                        Siap
                    </button>
                </div>
            </div>
        </div>
    `).join('');

    html += ready.map(o => `
        <div class="border border-brand-soft/40 rounded-3xl p-4 mb-4 bg-white/80 shadow-xl backdrop-blur-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-semibold text-[#3F2B25]">${o.order_number}</span>
                        <span class="px-2 py-0.5 bg-[#D9E8D7] text-[#D9703E] rounded-full text-xs">Siap Diambil</span>
                    </div>
                    <p class="text-xs text-[#3F2B25]">${o.customer_name}${o.no_whatsapp ? ` &bull; WA: ${o.no_whatsapp}` : ''}</p>
                    <p class="text-xs text-[#3F2B25] mt-2">Metode: ${o.order_method === 'delivery' ? 'Antar' : 'Pickup'}</p>
                    ${o.order_method === 'delivery' && (o.city || o.district || o.address) ? `<p class="text-xs text-[#3F2B25]">Alamat: ${[o.city, o.district, o.address].filter(Boolean).join(', ')}</p>` : ''}
                    ${o.delivery_time ? `<p class="text-xs text-[#3F2B25]">Jam: ${o.delivery_time}</p>` : ''}
                </div>
                <div class="flex items-center gap-3 flex-wrap">
                    <p class="text-sm font-semibold text-[#D9703E]">${formatRupiah(o.total_amount)}</p>
                    ${o.order_method === 'delivery' ? `
                    <a href="/kasir/delivery-note/${o.order_number}" target="_blank"
                        class="px-4 py-2 bg-[#E2E8F0] hover:bg-[#CBD5E1] text-[#1F2937] rounded-2xl text-sm font-semibold transition shadow-sm">
                        Surat Jalan
                    </a>
                    ` : ''}
                    <a href="/kasir/invoice/${o.order_number}" target="_blank"
                        class="px-4 py-2 bg-[#F4E1D8] hover:bg-[#E6C9B6] text-[#3F2B25] rounded-2xl text-sm font-semibold transition shadow-sm">
                        Invoice
                    </a>
                    <button onclick="updateStatus(${o.id}, 'completed')"
                        class="px-4 py-2 bg-brand-primary hover:bg-brand-primary-dark text-brand-white rounded-2xl text-sm font-semibold transition shadow-sm">
                        Selesai
                    </button>
                </div>
            </div>
        </div>
    `).join('');
    wrap.innerHTML = html;
}

function redirectToLogin() {
    window.location.href = LOGIN_URL;
}

function pollDashboard() {
    fetch(POLL_URL, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => {
            if (r.status === 401 || r.status === 419) {
                redirectToLogin();
                throw new Error('Unauthorized');
            }
            if (!r.ok) {
                throw new Error('Network response was not ok');
            }
            return r.json();
        })
        .then(data => {
            // Notif jika ada order baru masuk
            if (data.pending_review.length > lastPendingCount) {
                showToast('success', `${data.pending_review.length - lastPendingCount} order baru menunggu verifikasi!`);
            }
            lastPendingCount = data.pending_review.length;

            renderPendingReview(data.pending_review);
            renderOrderManagement(data.processing_orders, data.ready_orders);

            // Update live dot
            const dot = document.getElementById('live-dot');
            if (dot) {
                dot.classList.remove('bg-gray-400');
                dot.classList.add('bg-green-500');
                setTimeout(() => {
                    dot.classList.remove('bg-green-500');
                    dot.classList.add('bg-gray-400');
                }, 500);
            }
        })
        .catch(() => {
            const dot = document.getElementById('live-dot');
            if (dot) dot.classList.add('bg-brand-primary');
        });
}

// ── Auto Polling ──────────────────────────────────────────────
setInterval(pollDashboard, 3000);

window.addEventListener('pageshow', function(event) {
    const navigation = performance.getEntriesByType('navigation')[0];
    if (event.persisted || (navigation && navigation.type === 'back_forward')) {
        window.location.reload();
    }
});

// ── Auto Logout / Redirect Idle ───────────────────────────────────
let idleTimeout;
const IDLE_LIMIT_MS = 5 * 60 * 1000; // 5 menit
const LOGIN_URL = '{{ route('kasir.login') }}';

function resetIdleTimer() {
    if (idleTimeout) {
        clearTimeout(idleTimeout);
    }
    idleTimeout = setTimeout(() => {
        window.location.href = LOGIN_URL;
    }, IDLE_LIMIT_MS);
}

function initIdleRedirect() {
    const events = ['mousemove', 'mousedown', 'keydown', 'touchstart', 'scroll'];
    events.forEach(event => window.addEventListener(event, resetIdleTimer, true));
    resetIdleTimer();
}

window.addEventListener('load', initIdleRedirect);

// Fitur Tambahan: Menampilkan dan menyembunyikan modal
function bukaModalTunai(orderId) {
    // Pembayaran tunai telah dinonaktifkan
    showToast('warning', 'Pembayaran tunai sedang tidak tersedia.');
    return false;
}

function tutupModalTunai(orderId) {
    document.getElementById('modalTunaiMurni-' + orderId).classList.add('hidden');
}

function hitungKembalian(orderId) {
    const totalHarga = parseInt(document.getElementById('total_harga-' + orderId).value) || 0;
    const uangDiterima = parseInt(document.getElementById('cash_received-' + orderId).value) || 0;
    const infoKembalian = document.getElementById('info-kembalian-' + orderId);
    const btnKonfirmasi = document.getElementById('btn-konfirmasi-' + orderId);

    const kembalian = uangDiterima - totalHarga;

    if (uangDiterima === 0) {
        infoKembalian.innerText = "Rp 0";
        infoKembalian.className = "text-xl font-bold text-gray-500";
        btnKonfirmasi.disabled = true;
    } else if (kembalian < 0) {
        infoKembalian.innerText = "Uang Kurang: Rp " + Math.abs(kembalian).toLocaleString('id-ID');
        infoKembalian.className = "text-lg font-bold text-brand-primary dark:text-brand-primary-dark";
        btnKonfirmasi.disabled = true;
    } else {
        infoKembalian.innerText = "Rp " + kembalian.toLocaleString('id-ID');
        infoKembalian.className = "text-xl font-bold text-[#D9703E] dark:text-[#96C69C]";
        btnKonfirmasi.disabled = false;
    }
}
</script>

@if(session('cetak_struk_id'))
    <script>
        var urlStruk = "{{ route('kasir.cetakStruk', session('cetak_struk_id')) }}";
        window.open(urlStruk, '_blank');
    </script>
@endif
@endpush