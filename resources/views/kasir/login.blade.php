@extends('layouts.app')

@section('title', 'Login Kasir - POS Rumah Cake suprezz')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[radial-gradient(circle_at_top_left,_rgba(217,179,108,0.35),_transparent_30%),radial-gradient(circle_at_bottom_right,_rgba(36,72,40,0.22),_transparent_30%),linear-gradient(135deg,#f5edd7_0%,#d9b16d_50%,#5f6b3b_100%)] px-4 py-10 text-slate-900">
    <div class="relative w-full max-w-md">
        <div class="text-center mb-10">
            <img src="{{ asset('images/PT_rumah_cake_suprezz logo.png') }}" alt="Rumah Cake Suprezz" class="mx-auto w-28 h-28 object-contain">
            <h2 class="mt-6 text-3xl font-extrabold tracking-tight">Kasir Dashboard</h2>
            <p class="mt-2 text-base text-slate-800/80">Masuk untuk mengelola pesanan Rumah Cake Suprezz</p>
        </div>

        <div class="space-y-5 bg-white/80 backdrop-blur-xl rounded-[2rem] p-7 shadow-[0_30px_90px_rgba(0,0,0,0.12)] border border-white/60">
            @if($errors->any())
            <div class="rounded-3xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('kasir.login.submit') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="username" class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus
                        class="w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-primary-500 focus:ring-4 focus:ring-primary-200"
                        placeholder="Masukkan username">
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-primary-500 focus:ring-4 focus:ring-primary-200"
                        placeholder="Masukkan password">
                </div>

                <div class="flex items-center justify-between text-sm text-slate-700">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" id="remember" name="remember"
                            class="h-4 w-4 rounded border-slate-400 text-primary-600 focus:ring-primary-500">
                        Ingat saya
                    </label>
                    <a href="{{ route('kasir.password.request') }}" class="text-primary-700 hover:text-primary-900 transition">Lupa password?</a>
                </div>

                <button type="submit"
                    class="w-full rounded-full bg-gradient-to-r from-primary-600 via-primary-500 to-primary-700 px-5 py-3 text-white font-semibold shadow-lg transition hover:-translate-y-0.5 hover:shadow-2xl focus:outline-none focus:ring-4 focus:ring-primary-200">
                    Masuk Dashboard
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-sm text-primary-900/75">Belum punya akun? Hubungi admin untuk aktivasi kasir.</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleDarkMode() {
    const html = document.documentElement;
    if (html.classList.contains('dark')) {
        html.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    } else {
        html.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.documentElement.classList.add('dark');
    } else if (savedTheme === 'light') {
        document.documentElement.classList.remove('dark');
    }
});
</script>
@endpush
