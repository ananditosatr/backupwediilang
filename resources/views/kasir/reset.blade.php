@extends('layouts.app')

@section('title', 'Reset Password - Kasir')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 px-4">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto bg-gradient-to-br from-red-600 to-red-700 rounded-xl flex items-center justify-center shadow-lg mb-4">
                <span class="text-2xl font-bold text-white">POS</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Atur Ulang Password</h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Masukkan password baru Anda.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
            @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <p class="text-sm text-red-600 dark:text-red-400">{{ $errors->first() }}</p>
            </div>
            @endif

            <form method="POST" action="{{ route('kasir.password.update') }}" class="space-y-5">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Username</label>
                    <input type="text" id="username" name="username" value="{{ $username ?? old('username') }}" required autofocus
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition"
                        placeholder="Username">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password Baru</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition"
                        placeholder="Masukkan password baru">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition"
                        placeholder="Ulangi password baru">
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold py-3 px-4 rounded-lg hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition shadow-lg">
                    Reset Password
                </button>
            </form>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('kasir.login') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Kembali ke login</a>
        </div>
    </div>
</div>
@endsection
