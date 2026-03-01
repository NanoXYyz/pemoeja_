@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div id="page-login" class="mt-10 page active min-h-screen bg-slate-950 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    {{-- <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-blue-500/10 blur-[120px]"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-indigo-500/10 blur-[120px]"></div>
    </div> --}}

    <div class="justify-center relative w-full max-w-4xl flex flex-col md:flex-row bg-slate-900/50 border border-slate-800 rounded-3xl overflow-hidden backdrop-blur-xl shadow-2xl">
        
        <div class="w-full md:w-1/2 p-8 lg:p-12 flex flex-col justify-center">
            <div class="mb-10 text-center md:text-left relative">
                <h1 class="text-4xl font-extrabold text-white tracking-tight mb-2">
                    Bolu<span class="text-blue-500">.</span>
                </h1>
                <p class="text-gray-400 font-medium">Selamat datang kembali! Silakan masuk.</p>
                
                <button type="button" onclick="window.history.back()" class="absolute -top-4 -right-4 md:hidden text-gray-500 hover:text-white p-2">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form action="{{ route('auth.login') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-500 group-focus-within:text-blue-500 transition-colors"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full pl-11 pr-4 py-3.5 bg-slate-800/40 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all outline-none placeholder:text-gray-600"
                            placeholder="nama@email.com" required autofocus>
                    </div>
                    @error('email')
                        <p class="text-red-400 text-xs mt-1 transition-all animate-fade-in">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-500 group-focus-within:text-blue-500 transition-colors"></i>
                        </div>
                        <input type="password" name="password" id="password"
                            class="w-full pl-11 pr-12 py-3.5 bg-slate-800/40 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all outline-none placeholder:text-gray-600"
                            placeholder="••••••••" required>
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-blue-400 transition-colors">
                            <i class="fas fa-eye" id="eye-icon"></i>
                        </button>
                    </div>
                </div>

                @if (session('error'))
                    <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm flex items-center gap-3">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="remember"
                            class="w-4 h-4 rounded border-slate-700 bg-slate-800 text-blue-600 focus:ring-blue-500 focus:ring-offset-slate-900 transition-all">
                        <span class="text-sm text-gray-400 group-hover:text-gray-200 transition-colors">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm text-blue-400 hover:text-blue-300 font-semibold transition-colors">Lupa Password?</a>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-3 py-4 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-2xl transition-all shadow-lg shadow-blue-600/20 hover:shadow-blue-600/40 active:scale-[0.98]">
                        <span>Masuk Sekarang</span>
                        <i class="fas fa-arrow-right text-sm"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="hidden md:block md:w-1/2 relative">
            <img src="{{ asset('img/login.jpg') }}" alt="Login Cover" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/20 to-transparent"></div>
            {{-- <div class="absolute bottom-12 left-12 right-12">
                <blockquote class="text-white text-lg font-medium italic">
                    "Kelola data Anda dengan lebih mudah, cepat, dan aman dalam satu platform terintegrasi."
                </blockquote>
                <div class="mt-4 flex gap-2">
                    <div class="w-8 h-1 bg-blue-500 rounded-full"></div>
                    <div class="w-4 h-1 bg-slate-500 rounded-full"></div>
                    <div class="w-4 h-1 bg-slate-500 rounded-full"></div>
                </div>
            </div> --}}
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