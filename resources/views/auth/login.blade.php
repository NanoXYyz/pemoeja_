@extends('layouts.app')

@section('title', 'Login')

@section('content')
    {{-- 
       PERBAIKAN UTAMA: 
       1. Menggunakan h-screen (atau min-h-screen)
       2. Menghapus calc jika navbar bersifat fixed, atau sesuaikan flex layout-nya.
       3. Memastikan tidak ada margin top (mt) yang mengganggu.
    --}}
    <div id="page-login"
        class="flex flex-col justify-center items-center min-h-[calc(100vh-80px)] w-full py-4 px-4 sm:px-6 lg:px-8">

        {{-- Card Wrapper --}}
        <div
            class="relative w-full max-w-4xl flex flex-col md:flex-row bg-slate-900/50 border border-slate-800 rounded-3xl overflow-hidden backdrop-blur-xl shadow-2xl">

            {{-- Sisi Kiri: Form Login --}}
            <div class="w-full md:w-1/2 p-8 lg:p-12 flex flex-col justify-center">
                <div class="mb-3 text-center md:text-left relative">
                    <h1 class="text-4xl font-extrabold text-white tracking-tight mb-2">
                        Bolu<span class="text-blue-500">.</span>
                    </h1>
                    <p class="text-gray-400 font-medium text-sm">Selamat datang kembali! Silakan masuk.</p>
                </div>

                <form action="{{ route('auth.login') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="space-y-2">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Email
                            Address</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i
                                    class="fas fa-envelope text-gray-500 group-focus-within:text-blue-500 transition-colors"></i>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full pl-11 pr-4 py-3 bg-slate-800/40 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all outline-none placeholder:text-gray-600 text-sm"
                                placeholder="nama@email.com" required autofocus>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label
                            class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Password</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-500 group-focus-within:text-blue-500 transition-colors"></i>
                            </div>
                            <input type="password" name="password" id="password"
                                class="w-full pl-11 pr-12 py-3 bg-slate-800/40 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all outline-none placeholder:text-gray-600 text-sm"
                                placeholder="••••••••" required>
                            <button type="button" onclick="togglePassword()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-blue-400 transition-colors">
                                <i class="fas fa-eye" id="eye-icon"></i>
                            </button>
                        </div>
                    </div>

                    @error('email')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <div class="flex items-center justify-between text-xs">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="remember"
                                class="w-4 h-4 rounded border-slate-700 bg-slate-800 text-blue-600 focus:ring-blue-500">
                            <span class="text-gray-400 group-hover:text-gray-200">Ingat saya</span>
                        </label>
                    </div>

                    <div class="pt-1">
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-3 py-3.5 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-2xl transition-all shadow-lg shadow-blue-600/20 active:scale-[0.98]">
                            <span>Masuk Sekarang</span>
                            <i class="fas fa-arrow-right text-sm"></i>
                        </button>
                        <div class="text-center pt-2">
                            <a href="{{ route('content.dashboard') }}"
                                class="text-blue-400 hover:text-blue-300 font-semibold">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Sisi Kanan --}}
            <div class="hidden md:block md:w-1/2 relative min-h-[450px]">
                <img src="{{ asset('img/login.jpg') }}" alt="Login Cover"
                    class="absolute inset-0 w-full h-full object-cover">
                {{-- <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent"></div> --}}
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
@endsection
