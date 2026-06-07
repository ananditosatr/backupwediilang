@extends('layouts.app')

@section('title', 'Lupa Password - Kasir')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 px-4">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <img src="{{ asset('images/PT_rumah_cake_suprezz logo.png') }}" alt="PT Rumah Cake Suprezz" class="w-16 h-16 mx-auto object-contain mb-4">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Reset Password Kasir</h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Masukkan username Anda untuk menerima instruksi reset.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
            @if(session('status'))
            <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-sm text-green-700 dark:text-green-300">{{ session('status') }}</p>
            </div>
            @endif

            <form method="POST" action="{{ route('kasir.password.email') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition"
                        placeholder="Masukkan username">
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold py-3 px-4 rounded-lg hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition shadow-lg">
                    Kirim Link Reset
                </button>
            </form>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('kasir.login') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Kembali ke login</a>
        </div>
    </div>
</div>
@endsection
