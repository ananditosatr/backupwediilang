@extends('layouts.app')

@section('title', 'Order Menu - POS Rumah Cake suprezz')

@section('content')
<div class="min-h-screen">

    <!-- Header -->
    <header class="bg-[#D9703E] shadow sticky top-0 z-40">
        <div class="max-w-2xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/PT_rumah_cake_suprezz logo.png') }}" alt="PT Rumah Cake Suprezz" class="w-12 h-12 object-contain">
                <div>
                    <h1 class="text-base font-bold text-white">Order Menu</h1>
                    <p class="text-xs text-[#FFE5D5]">Scan QR & Order</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <button type="button" onclick="toggleDarkMode()" class="inline-flex items-center justify-center w-10 h-10 text-white hover:bg-[#C1542A] rounded-full transition">
                    <svg id="icon-moon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                    </svg>
                    <svg id="icon-sun" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"/>
                    </svg>
                </button>
                <a href="https://wa.me/{{ env('WHATSAPP_NUMBER') }}?text={{ urlencode('Halo, saya ingin bertanya tentang produk dan pemesanan.') }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center justify-center w-10 h-10 text-white hover:text-[#F3E3D7] transition">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.81.34 1.6.65 2.34a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.74-1.74a2 2 0 0 1 2.11-.45c.74.31 1.53.53 2.34.65A2 2 0 0 1 22 16.92z"/>
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <div class="max-w-2xl mx-auto px-4 pt-3 pb-2">
        <div class="flex justify-end">
            
        </div>
    </div>

    <!-- Category Filter -->
    <div class="max-w-2xl mx-auto px-4 pt-4 pb-2">
        <div class="flex space-x-2 overflow-x-auto pb-2 scrollbar-hide">
            <button onclick="filterCategory('all', this)"
                class="category-btn active-cat flex-shrink-0 px-4 py-2 bg-[#D9703E] text-white rounded-full text-sm font-medium whitespace-nowrap">
                Semua
            </button>
            @foreach($categories as $category)
            <button onclick="filterCategory({{ $category->id }}, this)"
                class="category-btn flex-shrink-0 px-4 py-2 bg-white border border-[#E2E8F0] text-[#3F2B25] rounded-full text-sm font-medium hover:bg-[#FFAA64] whitespace-nowrap transition">
                {{ $category->name }}
            @endforeach
        </div>
    </div>

    <!-- Menu Grid -->
    <main class="max-w-2xl mx-auto px-4 pb-28">
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <div class="grid grid-cols-2 gap-3">
            @foreach($menus as $menu)
            <div class="menu-card card-strong bg-white rounded-xl overflow-hidden hover:shadow-md transition border border-[#E2E8F0]"
                data-category="{{ $menu->category_id }}">
                <div class="aspect-square bg-transparent flex items-center justify-center">
                    @if($menu->image_base64)
                    <img src="{{ $menu->image_base64 }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                    @else
                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1M4.22 4.22l.71.71m13.66 13.66.71.71M1 12h1m20 0h1M4.22 19.78l.71-.71M19.07 4.93l.71-.71M12 7a5 5 0 100 10A5 5 0 0012 7z"/></svg>
                    @endif
                </div>
                <div class="p-3 bg-[#FAFAFA]">
                    <h3 class="font-semibold text-[#3F2B25] text-sm mb-1">{{ $menu->name }}</h3>
                    <p class="text-xs text-[#6B4F3F] mb-2 line-clamp-2">{{ $menu->description }}</p>
                    <div class="flex items-center justify-between">
                        <span class="menu-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                        <button onclick="addToCart({{ $menu->id }}, '{{ addslashes($menu->name) }}', {{ $menu->price }})"
                            class="w-8 h-8 bg-[#D9703E] hover:bg-[#C1542A] text-white rounded-full flex items-center justify-center transition shadow">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
        </div>
    </main>

    <!-- Cart FAB -->
    <div id="cart-fab" class="hidden fixed bottom-6 right-6 z-50">
        <button onclick="openCart()"
            class="relative w-14 h-14 cart-fab-btn text-white rounded-full flex items-center justify-center transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span id="cart-count" class="absolute -top-1 -right-1 w-5 h-5 cart-fab-badge text-xs font-bold rounded-full flex items-center justify-center shadow">0</span>
        </button>
    </div>

</div>

<!-- ===== MODALS ===== -->

<!-- Cart Modal -->
<div id="cart-content" class="hidden fixed inset-0 z-40 flex items-center justify-center p-4 bg-black/30 pointer-events-none" onclick="closeCart()">
    <div id="cart-content-body" class="pointer-events-auto w-full max-w-xl bg-white dark:bg-[#F4E3D9] rounded-[32px] shadow-2xl overflow-y-auto max-h-[90vh] flex flex-col" onclick="event.stopPropagation()">
        <!-- Cart header & body injected by JS -->
    </div>
</div>

<!-- Step 1: Checkout Modal — pilih metode pembayaran dan upload bukti -->
<div id="checkout-modal" class="hidden fixed inset-0 bg-[#3B2A22]/70 z-50 flex items-center justify-center p-4 pointer-events-none">
    <div class="pointer-events-auto bg-white dark:bg-[#F4E3D9] rounded-[32px] w-full max-w-[520px] overflow-hidden shadow-2xl border border-[#E2E8F0]/80 dark:border-[#3F2B25] flex flex-col max-h-[90vh]">
        <div class="px-6 py-5 bg-[#FAFAFA] dark:bg-[#F4F5F7] border-b border-[#E2E8F0]/80 dark:border-[#3F2B25]">
            <div class="flex items-center justify-between">
                <button onclick="closeCheckout()" class="p-2 rounded-2xl text-[#3F2B25] hover:bg-[#FFAA64] dark:hover:bg-[#3F2B25] transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <div class="text-center flex-1">
                    <p id="payment-method-label" class="text-[11px] tracking-[0.28em] uppercase text-[#2C1A11] dark:text-[#C9AC9A] mb-1">Pilih Metode Pembayaran</p>
                    <h2 class="text-lg font-bold text-[#2C1A11] dark:text-[#2C1A11]">Konfirmasi Pembayaran</h2>
                </div>
                <div class="w-9"></div>
            </div>
        </div>

            <div class="px-6 py-6 space-y-5 bg-[#F3E3D7] dark:bg-[#F3E3D7] overflow-y-auto flex-1">
            <div class="grid grid-cols-2 gap-3">
                <button id="button-qris" onclick="setPaymentMethod('qris')" type="button"
                    class="rounded-3xl border border-[#E2E8F0] dark:border-[#3F2B25] bg-[#FAFAFA] dark:bg-[#F4F5F7] p-4 text-sm font-semibold text-[#3F2B25] shadow-sm hover:border-[#D9703E] transition">
                    QRIS
                </button>
                <button id="button-transfer" onclick="setPaymentMethod('transfer')" type="button"
                    class="rounded-3xl border border-[#E2E8F0] dark:border-[#3F2B25] bg-[#FAFAFA] dark:bg-[#F4F5F7] p-4 text-sm font-semibold text-[#3F2B25] shadow-sm hover:border-[#D9703E] transition">
                    Transfer Bank
                </button>
            </div>

            <div class="rounded-[28px] border border-[#CDEAD8] p-5 shadow-sm bg-[#FFAA64]">
                <p class="text-xs text-[#3F2B25] mb-2">Total yang harus dibayar</p>
                <p class="text-3xl font-extrabold text-[#3F2B25]">Rp <span id="display-total"></span></p>
            </div>

            <div id="qris-section" class="rounded-[28px] border border-[#E2E8F0] dark:border-[#3F2B25] bg-[#FAFAFA] dark:bg-[#F4F5F7] p-4 shadow-sm text-center">
                <img src="{{ asset('images/qris_simulasi.jpeg') }}" alt="QRIS Rumah Cake Suprezz" class="mx-auto w-40 h-40 object-contain">
                <p class="text-xs text-[#3F2B25] dark:text-[#C9AC9A] mt-3">Scan menggunakan m-banking atau e-wallet kamu</p>
            </div>

            <div id="transfer-section" class="hidden rounded-[28px] border border-[#E2E8F0] dark:border-[#3F2B25] bg-[#FAFAFA] dark:bg-[#F4F5F7] p-5 shadow-sm">
                <p class="text-sm font-semibold text-[#2C1A11] dark:text-[#2C1A11] mb-2">Rekening Tujuan</p>
                <div class="rounded-3xl bg-[#FAFAFA] dark:bg-[#3B2A22] p-4 text-left border border-[#E2E8F0] dark:border-[#4A352D]">
                    <p class="text-sm text-[#3F2B25] dark:text-white">Bank: BSI</p>
                    <p class="text-base font-bold text-[#3F2B25] dark:text-white">7174778177</p>
                    <p class="text-sm text-[#3F2B25] dark:text-white">a.n. Yusnita Suryaningsih</p>
                    <p class="text-xs text-[#6B4F3F] dark:text-white mt-3">Transfer sesuai total, lalu upload bukti bayar.</p>
                </div>
            </div>

            <div id="upload-area" class="rounded-[28px] border border-dashed border-[#E2E8F0] dark:border-[#3F2B25] bg-[#FAFAFA] dark:bg-[#F4F5F7] p-5 text-center cursor-pointer hover:border-[#D9703E] transition"
                onclick="document.getElementById('proof-file-input').click()">
                <input type="file" id="proof-file-input" accept="image/*" class="hidden" onchange="handleProofFile(event)">
                <div id="upload-placeholder">
                    <svg class="w-10 h-10 mx-auto text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <p class="text-sm font-semibold text-[#2C1A11] dark:text-[#2C1A11]">Upload Bukti Bayar</p>
                    <p class="text-xs text-[#7A6A61] dark:text-[#C9AC9A] mt-1">PNG, JPG maksimal 2MB</p>
                </div>
                <div id="upload-preview" class="hidden">
                    <img id="preview-img" class="mx-auto rounded-3xl shadow-xl max-h-52 mb-3 border border-[#D8C3B7] dark:border-[#3F2B25]">
                    <p class="text-sm text-[#D9703E] dark:text-[#C1542A] font-semibold">Bukti terpilih — klik untuk ganti</p>
                </div>
            </div>

            <div class="sticky bottom-0 left-0 right-0 bg-gradient-to-t from-[#F4E3D9] to-transparent dark:from-[#F4E3D9] dark:to-transparent pt-2 pb-2">
                <button id="sudah-bayar-btn" onclick="proceedToPayment()" disabled
                    class="w-full py-3 rounded-3xl font-bold text-sm transition flex items-center justify-center gap-2 bg-[#8A4E2F] text-white dark:bg-[#3F2B25] dark:text-[#C9AC9A] cursor-not-allowed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Saya Sudah Bayar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Step 2: Form Data Diri — setelah bayar -->
<div id="payment-modal" class="hidden fixed inset-0 bg-[#3B2A22]/60 z-50 flex items-center justify-center p-4 pointer-events-none">
    <div class="pointer-events-auto bg-[#F4E3D9] dark:bg-[#F4E3D9] rounded-2xl w-full max-w-md p-6 border border-[#D8C3B7] dark:border-[#3F2B25] max-h-[90vh] overflow-y-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-5">
            <button onclick="backToQRIS()" class="text-[#7A6A61] hover:text-[#2C1A11] dark:hover:text-[#2C1A11] flex items-center gap-1 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </button>
            <h2 class="text-base font-bold text-[#2C1A11] dark:text-[#2C1A11]">Data Pemesan</h2>
            <div class="w-16"></div>
        </div>

        <p class="text-xs text-secondary mb-4 -mt-2">
            Isi data di bawah agar pesananmu bisa diproses kasir.
        </p>

        <div class="mb-5">
            <p class="text-sm font-semibold text-[#2C1A11] mb-3">Metode Pesanan</p>
            <div class="inline-flex p-1 rounded-full bg-white border border-[#C9AC9A]">
                <button type="button" id="custBtnDelivery" onclick="custSetOrderMethod('delivery')"
                    class="px-4 py-2 rounded-full text-sm font-semibold text-[#2C1A11]">Delivery</button>
                <button type="button" id="custBtnPickup" onclick="custSetOrderMethod('pickup')"
                    class="px-4 py-2 rounded-full text-sm font-semibold text-[#2C1A11]">Pickup</button>
            </div>
            <p id="delivery-warning" class="mt-3 text-sm text-red-600 hidden">Delivery hanya tersedia untuk pesanan minimal <span id="min-delivery-amount"></span> item.</p>
            <input type="hidden" id="custOrderMethodInput" value="pickup">
        </div>

        <div id="custDeliveryForm" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-[#2C1A11] mb-1.5">Kota</label>
                    <select id="custCitySelect" class="w-full px-4 py-3 border border-[#C9AC9A] rounded-lg bg-[#F4E3D9] text-[#2C1A11] focus:ring-2 focus:ring-[#D9703E] focus:border-transparent">
                        <option value="Surabaya">Surabaya</option>
                        <option value="Sidoarjo">Sidoarjo</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-[#2C1A11] mb-1.5">Kecamatan</label>
                    <select id="custDistrictSelect" class="w-full px-4 py-3 border border-[#C9AC9A] rounded-lg bg-[#F4E3D9] text-[#2C1A11] focus:ring-2 focus:ring-[#D9703E] focus:border-transparent"></select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium text-[#2C1A11] mb-1.5">Alamat Lengkap</label>
                    <textarea id="custAddress" rows="2" class="w-full px-4 py-3 border border-[#C9AC9A] rounded-lg bg-[#F4E3D9] text-[#2C1A11] focus:ring-2 focus:ring-[#D9703E] focus:border-transparent resize-none" placeholder="Masukkan alamat lengkap..."></textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium text-[#2C1A11] mb-1.5">Jam Pengiriman</label>
                    <select id="custDeliveryTime" class="w-full px-4 py-3 border border-[#C9AC9A] rounded-lg bg-[#F4E3D9] text-[#2C1A11] focus:ring-2 focus:ring-[#D9703E] focus:border-transparent">
                    </select>
                </div>
            </div>
            <p class="text-xs text-[#7A6A61]">Semua opsi delivery gratis ongkir.</p>
        </div>

        <div id="custPickupInfo" class="hidden rounded-3xl border border-[#C9AC9A] bg-[#FFF4E6] p-4 text-sm text-[#2C1A11]">
            <p class="font-semibold">Pickup di:</p>
            <p>Wisma Gilang Permai Blok AE 02, RT 29 RW 08, Taman, Sidoarjo</p>
            <p class="mt-2 text-xs text-[#7A6A61]">Ambil langsung di kasir. Tidak perlu alamat dan jam pengiriman.</p>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-[#2C1A11] mb-1.5">
                Nama <span class="text-[#D9703E]">*</span>
            </label>
            <input type="text" id="customer-name" required
                class="w-full px-4 py-3 border border-[#C9AC9A] rounded-lg text-sm bg-[#F4E3D9] text-[#2C1A11] focus:ring-2 focus:ring-[#D9703E] focus:border-transparent"
                placeholder="Masukkan nama kamu">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#2C1A11] mb-1.5">
                No. WhatsApp <span class="text-[#D9703E]">*</span>
            </label>
            <input type="tel" id="customer-wa" required
                class="w-full px-4 py-3 border border-[#C9AC9A] rounded-lg text-sm bg-[#F4E3D9] text-[#2C1A11] focus:ring-2 focus:ring-[#D9703E] focus:border-transparent"
                placeholder="Contoh: 08123456789">
        </div>
        <div class="mb-5">
            <label class="block text-sm font-medium text-[#2C1A11] mb-1.5">
                Catatan <span class="text-xs text-secondary">(opsional)</span>
            </label>
            <textarea id="order-notes" rows="2"
                class="w-full px-4 py-3 border border-[#C9AC9A] rounded-lg text-sm bg-[#F4E3D9] text-[#2C1A11] focus:ring-2 focus:ring-[#D9703E] focus:border-transparent"
                placeholder="Contoh: tidak pakai pedas..."></textarea>
        </div>

        <div class="sticky bottom-0 left-0 right-0 bg-gradient-to-t from-[#F4E3D9] to-transparent pt-2 pb-2">
            <button id="submit-payment-btn" onclick="submitOrder()"
                class="w-full py-3.5 bg-[#D9703E] hover:bg-[#C1542A] text-white rounded-xl font-bold text-sm transition">
                Konfirmasi Pesanan
            </button>
        </div>
    </div>
</div>

<!-- Tracking Modal -->
<div id="tracking-modal" class="hidden fixed inset-0 overlay-panel z-50 flex items-start sm:items-center justify-center p-4 overflow-y-auto pointer-events-none">
    <div class="pointer-events-auto card-base rounded-[32px] w-full max-w-md overflow-hidden shadow-2xl border max-h-[90vh] flex flex-col">
        <div class="card-header border-b text-center px-6 py-5">
            <h2 class="text-lg font-bold title-primary">Track Pesanan</h2>
            <p class="text-[11px] tracking-[0.28em] uppercase text-muted mt-1">Order: <span id="track-order-number" class="font-mono font-bold text-accent"></span></p>
        </div>

        <div class="p-6 overflow-y-auto flex-1">
            <!-- Status Banner (muncul saat status penting) -->
            <div id="status-banner" class="hidden mb-4 px-4 py-3 rounded-xl text-sm font-semibold text-center"></div>

            <div id="status-timeline" class="space-y-4 mb-4">
                <!-- filled by JS -->
            </div>

            <p class="text-xs text-center text-gray-400 dark:text-gray-500 mb-4">Auto refresh setiap 5 detik</p>

            <div class="px-0 pb-6">
                <button onclick="newOrder()" class="w-full py-3 bg-gradient-to-r from-[#D9703E] to-[#C1542A] text-white rounded-xl font-bold text-sm transition">
                    Pesan Lagi
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toast -->
<div id="toast" class="hidden fixed top-4 right-4 z-50 px-5 py-3 rounded-lg shadow-lg text-white text-sm font-medium"></div>
@endsection

@push('scripts')
<script>
// ===== STATE =====
let cart = [];
let currentOrder = null;
let trackingInterval = null;
let proofFile = null;
let proofBase64 = null;
let paymentMethod = 'qris';
const minDeliveryItems = @json(config('kasir.min_delivery_items', 20));

// ===== DARK MODE =====
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
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
    updateDarkModeIcons();
}

document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    updateDarkModeIcons();
    loadCart();
    resumeTrackingIfAny();
});

// Customer order method selector behaviors
function custSetOrderMethod(method) {
    const items = getCartItemCount();
    if (method === 'delivery' && items < minDeliveryItems) {
        showToast('error', `Delivery hanya tersedia untuk pesanan minimal ${minDeliveryItems} item`);
        method = 'pickup';
    }
    const input = document.getElementById('custOrderMethodInput');
    input.value = method;
    const deliveryForm = document.getElementById('custDeliveryForm');
    const pickupInfo = document.getElementById('custPickupInfo');
    if (method === 'delivery') {
        deliveryForm.classList.remove('hidden');
        pickupInfo.classList.add('hidden');
    } else {
        deliveryForm.classList.add('hidden');
        pickupInfo.classList.remove('hidden');
    }
    custUpdateToggleStyles(method);
}

function custUpdateToggleStyles(method) {
    const btnDelivery = document.getElementById('custBtnDelivery');
    const btnPickup = document.getElementById('custBtnPickup');
    if (!btnDelivery || !btnPickup) return;
    if (method === 'delivery') {
        btnDelivery.classList.add('bg-[#D9703E]', 'text-white');
        btnDelivery.classList.remove('text-[#3F2B25]');
        btnPickup.classList.remove('bg-[#D9703E]', 'text-white');
        btnPickup.classList.add('text-[#3F2B25]');
    } else {
        btnPickup.classList.add('bg-[#D9703E]', 'text-white');
        btnPickup.classList.remove('text-[#3F2B25]');
        btnDelivery.classList.remove('bg-[#D9703E]', 'text-white');
        btnDelivery.classList.add('text-[#3F2B25]');
    }
}

function getCartItemCount() {
    return cart.reduce((sum, item) => sum + item.quantity, 0);
}

function getCartTotal() {
    return cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
}

function custUpdateDeliveryAvailability(count) {
    const btnDelivery = document.getElementById('custBtnDelivery');
    const warning = document.getElementById('delivery-warning');
    const minAmount = document.getElementById('min-delivery-amount');
    if (!btnDelivery || !warning || !minAmount) return;

    minAmount.textContent = minDeliveryItems;
    if (count < minDeliveryItems) {
        btnDelivery.disabled = true;
        btnDelivery.classList.add('opacity-50', 'cursor-not-allowed');
        btnDelivery.classList.remove('bg-[#D9703E]', 'text-white');
        btnDelivery.classList.add('text-[#6B7280]');
        warning.classList.remove('hidden');
        if (document.getElementById('custOrderMethodInput').value === 'delivery') {
            custSetOrderMethod('pickup');
        }
    } else {
        btnDelivery.disabled = false;
        btnDelivery.classList.remove('opacity-50', 'cursor-not-allowed', 'text-[#6B7280]');
        warning.classList.add('hidden');
    }
}

function custPopulateDistricts(city) {
    const map = {
        'Surabaya': [
            'Asemrowo','Benowo','Bubutan','Bulak','Dukuh Pakis','Gayungan','Gubeng','Gunung Anyar','Jambangan','Karang Pilang','Kenjeran','Krembangan','Lakar Santri','Mulyorejo','Pabean Cantikan','Pakal','Rungkut','Sambikerep','Sawahan','Semampir','Simokerto','Sukolilo','Sukomanunggal','Tambaksari','Tandes','Tegalsari','Tenggilis Mejoyo','Toalan','Wiyung','Wonocolo','Wonokromo'
        ],
        'Sidoarjo': [
            'Balongbendo','Buduran','Candi','Gedangan','Jabon','Krembung','Krian','Malingping','Porong','Prambon','Sedati','Sidoarjo','Sukodono','Taman','Tanggulangin','Tarik','Tulangan','Waru','Wonoayu'
        ]
    };
    const sel = document.getElementById('custDistrictSelect');
    if (!sel) return;
    sel.innerHTML = '';
    (map[city] || []).forEach(d => {
        const opt = document.createElement('option'); opt.value = d; opt.text = d; sel.appendChild(opt);
    });
}

function custPopulateDeliveryTimes() {
    const sel = document.getElementById('custDeliveryTime');
    if (!sel) return;
    sel.innerHTML = '';
    for (let h = 7; h <= 21; h++) {
        const hh = h.toString().padStart(2, '0');
        const option = document.createElement('option');
        option.value = `Jam ${hh}.00 WIB`;
        option.text = `Jam ${hh}.00 WIB`;
        sel.appendChild(option);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const citySel = document.getElementById('custCitySelect');
    if (citySel) {
        custPopulateDistricts(citySel.value);
        citySel.addEventListener('change', function () { custPopulateDistricts(this.value); });
    }
    custPopulateDeliveryTimes();
    const initial = document.getElementById('custOrderMethodInput')?.value || 'pickup';
    custSetOrderMethod(initial);
});

function resumeTrackingIfAny() {
    const savedOrder = localStorage.getItem('active_order');
    if (!savedOrder) return;

    // Cek dulu ke server apakah order masih aktif
    fetch(`/orders/${savedOrder}`)
        .then(r => r.json())
        .then(order => {
            const terminal = ['completed', 'cancelled'];
            if (terminal.includes(order.status)) {
                localStorage.removeItem('active_order');
                return;
            }
            // Order masih aktif, resume tracking
            currentOrder = order;
            openTracking(savedOrder);
        })
        .catch(() => {});
}

// ===== CATEGORY FILTER =====
function filterCategory(categoryId, btn) {
    document.querySelectorAll('.category-btn').forEach(b => {
        b.classList.remove('bg-[#D9703E]', 'bg-[#7A3F25]', 'text-white', 'active-cat');
        b.classList.add('bg-white', 'dark:bg-[#ECDCCB]', 'border', 'border-[#E2E8F0]', 'dark:border-[#3F2B25]', 'text-[#3F2B25]', 'dark:text-[#2C1A11]');
    });
    btn.classList.add('bg-[#D9703E]', 'text-white', 'active-cat');
    btn.classList.remove('bg-white', 'dark:bg-[#ECDCCB]', 'border', 'border-[#E2E8F0]', 'dark:border-[#3F2B25]', 'text-[#3F2B25]', 'dark:text-[#2C1A11]');

    document.querySelectorAll('.menu-card').forEach(card => {
        if (categoryId === 'all' || card.dataset.category == categoryId) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}

// ===== CART =====
function addToCart(menuId, name, price) {
    const existing = cart.find(i => i.menu_id === menuId);
    if (existing) {
        existing.quantity++;
    } else {
        cart.push({ menu_id: menuId, name, price, quantity: 1 });
    }
    saveCart();
    updateCartBadge();
    showToast('success', name + ' ditambahkan');
}

function removeFromCart(index) {
    cart.splice(index, 1);
    saveCart();
    updateCartBadge();
    renderCart();
}

function changeQty(index, delta) {
    cart[index].quantity += delta;
    if (cart[index].quantity <= 0) {
        removeFromCart(index);
        return;
    }
    saveCart();
    renderCart();
}

function updateCartBadge() {
    const total = cart.reduce((s, i) => s + i.quantity, 0);
    const fab = document.getElementById('cart-fab');
    const count = document.getElementById('cart-count');
    if (total > 0) {
        count.textContent = total;
        fab.classList.remove('hidden');
    } else {
        fab.classList.add('hidden');
    }
}

function saveCart() { sessionStorage.setItem('cart', JSON.stringify(cart)); }
function loadCart() {
    const saved = sessionStorage.getItem('cart');
    if (saved) {
        cart = JSON.parse(saved);
        updateCartBadge();
    }
}

function openCart() {
    document.getElementById('cart-content').classList.remove('hidden');
    renderCart();
}


function closeCart() {
    document.getElementById('cart-content').classList.add('hidden');
}

function renderCart() {
    const container = document.getElementById('cart-content-body');
    const total = cart.reduce((s, i) => s + (i.price * i.quantity), 0);

    let html = `
        <div class="p-5 border-b border-[#E2E8F0] flex items-center justify-between flex-shrink-0 bg-[#D9703E]">
            <h2 class="text-base font-bold text-white">Keranjang</h2>
            <button onclick="closeCart()" class="text-white hover:text-[#FFE5D5]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    `;

    if (cart.length === 0) {
        html += `<div class="p-8 text-center flex-1">
            <p class="text-gray-400 dark:text-gray-500 text-sm">Keranjang masih kosong</p>
        </div>`;
    } else {
        html += `<div class="flex-1 overflow-y-auto p-4 space-y-3">`;
        cart.forEach((item, i) => {
            const sub = item.price * item.quantity;
            html += `
                <div class="bg-white dark:bg-[#ECDCCB] rounded-xl p-3">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="text-sm font-semibold text-[#3F2B25] dark:text-[#2C1A11]">${item.name}</p>
                            <p class="text-xs text-[#D9703E] dark:text-[#A8C9A9]">Rp ${item.price.toLocaleString('id-ID')}</p>
                        </div>
                        <button onclick="removeFromCart(${i})" class="text-gray-400 hover:text-[#D9703E] transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <button onclick="changeQty(${i}, -1)" class="w-7 h-7 bg-[#FAFAFA] dark:bg-[#4A352D] border border-[#E2E8F0] dark:border-[#5C3C2E] rounded-lg text-[#3F2B25] dark:text-white flex items-center justify-center hover:bg-[#FFAA64] transition">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                            </button>
                            <span class="text-sm font-bold text-[#3F2B25] dark:text-white w-4 text-center">${item.quantity}</span>
                            <button onclick="changeQty(${i}, 1)" class="w-7 h-7 bg-[#FAFAFA] dark:bg-[#4A352D] border border-[#E2E8F0] dark:border-[#5C3C2E] rounded-lg text-[#3F2B25] dark:text-white flex items-center justify-center hover:bg-[#FFAA64] transition">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </button>
                        </div>
                        <span class="text-sm font-bold text-[#D9703E]">Rp ${sub.toLocaleString('id-ID')}</span>
                    </div>
                </div>
            `;
        });
        html += `</div>`;

        
        html += `
            <div class="relative border-t border-[#E2E8F0] p-4 flex-shrink-0 bg-[#FAFAFA]">
                <div class="flex justify-between text-base font-bold mb-3">
                    <span class="text-[#3F2B25]">Total</span>
                    <span class="text-[#D9703E]">Rp ${total.toLocaleString('id-ID')}</span>
                </div>
                <button type="button" id="cartCheckoutBtn" onclick="proceedCheckout()" class="w-full py-3 bg-gradient-to-r from-[#D9703E] to-[#C1542A] text-white rounded-xl font-bold text-sm hover:from-[#C1542A] hover:to-[#A24423] transition shadow relative z-50 pointer-events-auto">
                    Lanjut Checkout
                </button>
            </div>
        `;
    }

    container.innerHTML = html;
}

function proceedCheckout() {
    if (cart.length === 0) return;
    closeCart();
    openCheckoutModal();
}

function setPaymentMethod(method) {
    paymentMethod = method;
    document.getElementById('payment-method-label').textContent = method === 'transfer' ? 'Pembayaran Transfer' : 'Pembayaran QRIS';

    const qrisSection = document.getElementById('qris-section');
    const transferSection = document.getElementById('transfer-section');
    
    if (method === 'qris') {
        qrisSection.classList.remove('hidden');
        transferSection.classList.add('hidden');
    } else {
        qrisSection.classList.add('hidden');
        transferSection.classList.remove('hidden');
    }

    const qrisBtn = document.getElementById('button-qris');
    const transferBtn = document.getElementById('button-transfer');

    if (method === 'qris') {
        qrisBtn.classList.add('border-[#D9703E]', 'bg-[#FFF1EF]', 'dark:bg-[#3F2B25]', 'dark:border-[#C1542A]', 'text-[#D9703E]');
        qrisBtn.classList.remove('border-[#C9AC9A]', 'bg-[#FAFAFA]', 'dark:bg-[#F4F5F7]', 'text-[#3F2B25]');
        transferBtn.classList.remove('border-[#D9703E]', 'bg-[#FFF1EF]', 'dark:bg-[#3F2B25]', 'dark:border-[#C1542A]', 'text-[#D9703E]');
        transferBtn.classList.add('border-[#E2E8F0]', 'bg-[#FAFAFA]', 'dark:bg-[#F4F5F7]', 'text-[#3F2B25]');
    } else {
        transferBtn.classList.add('border-[#D9703E]', 'bg-[#FFF1EF]', 'dark:bg-[#3F2B25]', 'dark:border-[#C1542A]', 'text-[#D9703E]');
        transferBtn.classList.remove('border-[#E2E8F0]', 'bg-[#FAFAFA]', 'dark:bg-[#F4F5F7]', 'text-[#3F2B25]');
        qrisBtn.classList.remove('border-[#D9703E]', 'bg-[#FFF1EF]', 'dark:bg-[#3F2B25]', 'dark:border-[#C1542A]', 'text-[#D9703E]');
        qrisBtn.classList.add('border-[#E2E8F0]', 'bg-[#FAFAFA]', 'dark:bg-[#F4F5F7]', 'text-[#3F2B25]');
    }
}

function openCheckoutModal() {
    const total = getCartTotal();
    document.getElementById('display-total').textContent = total.toLocaleString('id-ID');
    setPaymentMethod(paymentMethod);
    document.getElementById('proof-file-input').value = '';
    proofBase64 = null;
    proofFile = null;
    document.getElementById('upload-placeholder').classList.remove('hidden');
    document.getElementById('upload-preview').classList.add('hidden');
    const btn = document.getElementById('sudah-bayar-btn');
    btn.disabled = true;
    btn.className = 'w-full py-4 rounded-3xl font-bold text-sm transition flex items-center justify-center gap-2 bg-[#8A4E2F] text-white dark:bg-[#3F2B25] dark:text-[#C9AC9A] cursor-not-allowed';
    document.getElementById('checkout-modal').classList.remove('hidden');
}

function closeCheckout() {
    document.getElementById('checkout-modal').classList.add('hidden');
}

function proceedToPayment() {
    // Customer sudah bayar QRIS, tampilkan form data diri
    custUpdateDeliveryAvailability(getCartItemCount());
    closeCheckout();
    document.getElementById('payment-modal').classList.remove('hidden');
    document.getElementById('customer-name').focus();
}

function backToQRIS() {
    document.getElementById('payment-modal').classList.add('hidden');
    openQRISModal();
}

function handleProofFile(e) {
    const file = e.target.files[0];
    if (!file) return;
    if (file.size > 2 * 1024 * 1024) {
        e.target.value = '';
        Swal.fire({ icon: 'error', title: 'File terlalu besar', text: 'Ukuran foto maksimal 2MB.', confirmButtonColor: '#dc2626' });
        return;
    }
    proofFile = file;
    const reader = new FileReader();
    reader.onload = function(ev) {
        proofBase64 = ev.target.result;
        document.getElementById('preview-img').src = proofBase64;
        document.getElementById('upload-placeholder').classList.add('hidden');
        document.getElementById('upload-preview').classList.remove('hidden');
        // Aktifkan tombol Sudah Bayar
        const btn = document.getElementById('sudah-bayar-btn');
        btn.disabled = false;
        btn.className = 'w-full py-4 rounded-3xl font-bold text-sm transition flex items-center justify-center gap-2 bg-gradient-to-r from-[#D9703E] to-[#C1542A] hover:from-[#C1542A] hover:to-[#A24423] text-white shadow-lg';
    };
    reader.readAsDataURL(file);
}

// ===== ORDER SUBMISSION =====
function submitOrder() {
    const name = document.getElementById('customer-name').value.trim();
    const wa = document.getElementById('customer-wa').value.trim();

    if (!name) {
        showToast('error', 'Nama tidak boleh kosong');
        document.getElementById('customer-name').focus();
        return;
    }
    if (!wa) {
        showToast('error', 'No. WhatsApp tidak boleh kosong');
        document.getElementById('customer-wa').focus();
        return;
    }

    const btn = document.getElementById('submit-payment-btn');
    btn.disabled = true;
    btn.textContent = 'Memproses...';

    fetch('/orders', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken() },
        body: JSON.stringify({
            customer_name: name,
            no_whatsapp: wa,
            notes: document.getElementById('order-notes').value,
            proof_image: proofBase64,
            payment_method: paymentMethod,
            order_method: document.getElementById('custOrderMethodInput').value,
            city: document.getElementById('custCitySelect').value,
            district: document.getElementById('custDistrictSelect').value,
            address: document.getElementById('custAddress').value,
            delivery_time: document.getElementById('custDeliveryTime').value,
            items: cart
        })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            currentOrder = data.order;
            cart = [];
            saveCart();
            updateCartBadge();
            localStorage.setItem('active_order', data.order.order_number);
            document.getElementById('payment-modal').classList.add('hidden');
            resetPaymentForm();
            openTracking(data.order.order_number);
        } else {
            showToast('error', data.message || 'Gagal membuat pesanan');
            btn.disabled = false;
            btn.textContent = 'Konfirmasi Pesanan';
        }
    })
    .catch(() => {
        showToast('error', 'Terjadi kesalahan');
        btn.disabled = false;
        btn.textContent = 'Konfirmasi Pesanan';
    });
}

// ===== PAYMENT =====
function resetPaymentForm() {
    proofFile = null;
    proofBase64 = null;
    document.getElementById('proof-file-input').value = '';
    document.getElementById('upload-placeholder').classList.remove('hidden');
    document.getElementById('upload-preview').classList.add('hidden');
    const sudahBayarBtn = document.getElementById('sudah-bayar-btn');
    sudahBayarBtn.disabled = true;
    sudahBayarBtn.className = 'w-full py-4 rounded-3xl font-bold text-sm transition flex items-center justify-center gap-2 bg-[#8A4E2F] text-white dark:bg-[#3F2B25] dark:text-[#C9AC9A] cursor-not-allowed';
    document.getElementById('customer-name').value = '';
    document.getElementById('customer-wa').value = '';
    document.getElementById('order-notes').value = '';
    const btn = document.getElementById('submit-payment-btn');
    btn.disabled = false;
    btn.textContent = 'Konfirmasi Pesanan';
}

// ===== ORDER TRACKING =====
let lastTrackedStatus = null;

const statusNotif = {
    'pending_verification': { msg: 'Pesanan diterima! Kasir sedang memverifikasi...', type: 'info' },
    'processing':           { msg: 'Pembayaran disetujui! Pesananmu sedang disiapkan.', type: 'success' },
    'ready':                { msg: 'Pesananmu siap.', type: 'ready' },
    'completed':            { msg: 'Pesanan selesai. Terima kasih!', type: 'success' },
    'cancelled':            { msg: 'Pesanan dibatalkan.', type: 'error' },
};

function getReadyTrackingText(isDelivery) {
    return isDelivery
        ? 'Pesananmu sedang diantar, pesanamu dalam perjalanan.'
        : 'Pesananmu siap diambil, mohon segera diambil.';
}

function getReadyTrackingTitle(isDelivery) {
    return isDelivery ? 'Pesananmu Sedang Diantar' : 'Pesananmu Siap Diambil';
}

function getReadyTrackingDesc(isDelivery) {
    return isDelivery
        ? 'Pesananmu dalam perjalanan.'
        : 'Pesananmu siap diambil. Mohon segera diambil.';
}

function requestNotifPermission() {
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission();
    }
}

function sendBrowserNotif(title, body) {
    if (!('Notification' in window) || Notification.permission !== 'granted') return;
    try {
        const notif = new Notification(title, {
            body,
            icon: '/favicon.ico',
            badge: '/favicon.ico',
            tag: 'order-status',
            renotify: true,
        });
        setTimeout(() => notif.close(), 10000);
    } catch (e) {}
}

function openTracking(orderNumber) {
    lastTrackedStatus = null;
    document.getElementById('track-order-number').textContent = orderNumber;
    document.getElementById('tracking-modal').classList.remove('hidden');
    requestNotifPermission();
    fetchStatus(orderNumber);
    trackingInterval = setInterval(() => fetchStatus(orderNumber), 5000);
}

function fetchStatus(orderNumber) {
    fetch(`/orders/${orderNumber}`)
    .then(r => r.json())
    .then(order => {
        const effectiveStatus = order.status;
        const isDelivery = order.order_method === 'delivery';

        // Notifikasi saat status berubah (skip notif saat pertama kali load)
        if (lastTrackedStatus !== null && lastTrackedStatus !== effectiveStatus) {
            let notif = statusNotif[effectiveStatus];
            if (effectiveStatus === 'ready') {
                notif = { msg: getReadyTrackingText(isDelivery), type: 'ready' };
            }
            if (notif) {
                showTrackingNotif(notif.msg, notif.type);
                tryVibrate();
                const browserNotifs = {
                    'ready':      { title: getReadyTrackingTitle(isDelivery), body: getReadyTrackingDesc(isDelivery) },
                    'cancelled':  { title: 'Pesanan Dibatalkan', body: 'Pesananmu telah dibatalkan.' },
                    'processing': { title: 'Pesanan Diproses', body: 'Pembayaran diverifikasi. Pesananmu sedang disiapkan.' },
                };
                const bn = browserNotifs[effectiveStatus];
                if (bn) sendBrowserNotif(bn.title, bn.body);
            }
        }
        lastTrackedStatus = effectiveStatus;

        updateStatusBanner(effectiveStatus, isDelivery);
        renderTimeline(order);
    })
    .catch(() => {});
}

function updateStatusBanner(status, isDelivery = false) {
    const banner = document.getElementById('status-banner');
    if (!banner) return;

    const bannerConfig = {
        'pending_payment':      null,
        'pending_verification': { text: 'Menunggu verifikasi kasir...', cls: 'bg-[#FFF1EF] dark:bg-[#4A352D] text-[#D9703E] dark:text-[#F4E3D9] border border-[#CDEAD8] shadow-sm' },
        'processing':           { text: 'Pesananmu sedang disiapkan', cls: 'bg-[#FFF1EF] dark:bg-[#4A352D] text-[#D9703E] dark:text-[#F4E3D9] border border-[#CDEAD8] shadow-sm' },
        'ready':                { text: isDelivery ? 'Pesananmu sedang diantar, pesanamu dalam perjalanan.' : 'Pesananmu siap diambil, mohon segera diambil.', cls: 'bg-[#FFF1EF] dark:bg-[#274b2f] text-[#D9703E] dark:text-[#CFEBD6] border border-[#CDEAD8] dark:border-[#184022] animate-pulse shadow-sm' },
        'completed':            { text: 'Selesai! Terima kasih telah memesan.', cls: 'bg-[#FFF1EF] dark:bg-[#274b2f] text-[#D9703E] dark:text-[#CFEBD6] border border-[#CDEAD8] dark:border-[#184022] shadow-sm' },
        'cancelled':            { text: 'Pesanan dibatalkan.', cls: 'bg-[#FFF1EF] dark:bg-[#C1542A]/15 text-[#A24423] dark:text-[#C1542A] border border-[#C1542A]/40 dark:border-[#C1542A]/50 shadow-sm' },
    };

    const cfg = bannerConfig[status];
    if (!cfg) {
        banner.classList.add('hidden');
        return;
    }
    banner.textContent = cfg.text;
    banner.innerHTML = cfg.text;
    banner.className = `mb-4 px-4 py-3 rounded-xl text-sm font-semibold text-center ${cfg.cls}`;
    banner.classList.remove('hidden');
}

function showTrackingNotif(message, type) {
    const colors = {
        success: 'bg-green-500',
        error:   'bg-red-500',
        warning: 'bg-yellow-500',
        info:    'bg-blue-500',
        ready:   'bg-purple-600',
    };
    const toast = document.getElementById('toast');
    toast.className = `fixed top-4 right-4 z-50 px-5 py-4 rounded-xl shadow-xl text-white text-sm font-semibold max-w-xs ${colors[type] || 'bg-gray-700'}`;
    toast.innerHTML = `<span>${message}</span>`;
    toast.classList.remove('hidden');
    // Notif status penting tampil lebih lama
    const duration = (type === 'ready' || type === 'warning') ? 6000 : 4000;
    setTimeout(() => toast.classList.add('hidden'), duration);
}

function tryVibrate() {
    if (navigator.vibrate) navigator.vibrate([200, 100, 200]);
}

function renderTimeline(order) {
    // Handle cancelled
    if (order.status === 'cancelled') {
        document.getElementById('status-timeline').innerHTML = `
            <div class="text-center py-2">
                <div class="w-16 h-16 bg-[#D9703E]/10 dark:bg-[#C1542A]/30 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-[#D9703E] dark:text-[#C1542A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <p class="text-base font-bold text-[#D9703E] dark:text-[#C1542A] mb-1">Pesanan Dibatalkan</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Silakan hubungi kasir jika ada pertanyaan.</p>
            </div>
        `;
        clearInterval(trackingInterval);
        localStorage.removeItem('active_order');
        return;
    }

    // Hapus localStorage jika sudah completed
    if (order.status === 'completed') {
        localStorage.removeItem('active_order');
    }

    const isDelivery = order.order_method === 'delivery';
    const steps = [
        { key: 'pending_payment',      label: 'Pesanan Dibuat',     desc: 'Pesanan berhasil diterima' },
        { key: 'pending_verification', label: 'Verifikasi Bayar',   desc: 'Kasir sedang memverifikasi' },
        { key: 'processing',           label: 'Sedang Diproses',    desc: 'Pesanan sedang disiapkan' },
        { key: 'ready',                label: isDelivery ? 'Pesananmu Siap Diantar' : 'Pesananmu Siap Diambil', desc: isDelivery ? 'Pesananmu dalam perjalanan.' : 'Pesananmu siap diambil. Mohon segera diambil.' },
        { key: 'completed',            label: 'Selesai',            desc: 'Selamat menikmati!' },
    ];

    const currentIdx = steps.findIndex(s => s.key === order.status);
    let html = '';

    const isCompleted = order.status === 'completed';

    steps.forEach((step, i) => {
        const done = i < currentIdx || (isCompleted && i === currentIdx);
        const active = i === currentIdx && !isCompleted;
        const pending = i > currentIdx;

        const dotClass = done
            ? 'bg-[#D9703E]'
            : active
            ? 'bg-[#D9703E] shadow-lg shadow-[#D9703E]/20 animate-pulse'
            : 'bg-[#C9AC9A] dark:bg-[#6B5C4B]';

        const titleClass = active
            ? 'text-[#D9703E] dark:text-white font-semibold'
            : done
            ? 'text-[#3F2B25] dark:text-white font-semibold'
            : 'text-[#6B5340] dark:text-[#D1B8A8]';
        const descClass = active
            ? 'text-[#A24423] dark:text-[#F4E3D9]'
            : done
            ? 'text-[#5E4A3F] dark:text-[#D1B8A8]'
            : 'text-[#8A6E5C] dark:text-[#BDA78D]';
        const lineClass = done ? 'bg-[#D9703E]' : 'bg-[#D8C3B7] dark:bg-[#4A352D]';

        html += `
            <div class="rounded-3xl border border-[#E6D6C9] bg-[#FFF6F0] dark:bg-[#3B2A22] p-4 mb-3">
                <div class="flex items-start gap-3">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full ${dotClass} flex items-center justify-center flex-shrink-0">
                            ${done ? '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>' : ''}
                            ${active ? '<div class="w-4 h-4 bg-white rounded-full"></div>' : ''}
                        </div>
                        ${i < steps.length - 1 ? `<div class="w-0.5 h-8 ${lineClass} mt-1"></div>` : ''}
                    </div>
                    <div class="pb-1 text-[#3F2B25] dark:text-[#F4E3D9]">
                        <p class="text-sm ${titleClass}">${step.label}</p>
                        <p class="text-sm ${descClass} mt-1">${step.desc}</p>
                        ${active ? '<p class="text-xs text-[#D9703E] dark:text-[#F4E3D9] font-medium mt-2">Sedang berlangsung...</p>' : ''}
                    </div>
                </div>
            </div>
        `;
    });

    document.getElementById('status-timeline').innerHTML = html;
}

function newOrder() {
    clearInterval(trackingInterval);
    lastTrackedStatus = null;
    currentOrder = null;
    localStorage.removeItem('active_order');
    document.getElementById('tracking-modal').classList.add('hidden');
    document.getElementById('status-banner').classList.add('hidden');
}


// ===== UTILS =====
function showToast(type, message) {
    const colors = { success: 'bg-green-500', error: 'bg-red-500', warning: 'bg-yellow-500' };
    const toast = document.getElementById('toast');
    toast.className = `fixed top-4 right-4 z-50 px-5 py-3 rounded-lg shadow-lg text-white text-sm font-medium ${colors[type]}`;
    toast.textContent = message;
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 2500);
}

function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]').content;
}

// Cart delivery/pickup helpers removed per user request
</script>
@endpush
