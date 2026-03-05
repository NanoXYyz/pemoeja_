<div>
    <nav class="navbar-glass fixed top-0 left-0 right-0 z-50 px-4 md:px-8 w-full">
        <div class="max-w-7xl mx-auto flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <a href="/" class="font-black text-white text-lg tracking-tight">Pemoeja Bolu</a>
            </div>

            <!-- Nav Links -->
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('content.dashboard') }}"
                    class="nav-link px-4 py-2 rounded-lg text-sm {{ Route::is('content.dashboard') ? 'nav-active text-blue-400' : 'text-gray-400' }} transition-all">
                    Home
                </a>
                <a href="{{ route('anggota.index') }}"
                    class="nav-link px-4 py-2 rounded-lg text-sm {{ Route::is('anggota.*') ? 'nav-active text-blue-400' : 'text-gray-400' }} transition-all">
                    Anggota
                </a>

                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('keuangan.index') }}"
                            class="nav-link px-4 py-2 rounded-lg text-sm {{ Route::is('keuangan*') ? 'nav-active text-blue-400' : 'text-gray-400 hover:bg-navy-800 hover:text-white' }} transition-all">
                            Keuangan
                        </a>
                    @endif
                @endauth

                <a href="{{ route('lagu.index') }}"
                    class="nav-link px-4 py-2 rounded-lg text-sm {{ Route::is('lagu.*') ? 'nav-active text-blue-400' : 'text-gray-400' }} transition-all">
                    Lagu
                </a>

                <!-- Jadwal Dropdown -->
                @auth
                    @if (Auth::user()->role === 'admin')
                        <div class="relative" id="jadwalDropdownContainer">
                            <button onclick="toggleDropdown('jadwalDropdown')"
                                class="nav-link px-4 py-2 rounded-lg text-sm {{ Request::is('jadwal*') ? 'nav-active text-blue-400' : 'text-gray-400 hover:bg-navy-800 hover:text-white' }} transition-all flex items-center gap-1">
                                Jadwal <i class="fas fa-chevron-down text-xs opacity-60"></i>
                            </button>
                            <div id="jadwalDropdown" class="dropdown-menu absolute top-12 left-0 w-44 py-2 hidden z-50"
                                style="background: #0f2040; border: 1px solid rgba(59,127,255,0.2); border-radius: 10px;">
                                <a href="{{ route('jadwal.index') }}"
                                    class="w-full text-left px-4 py-2.5 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors flex items-center gap-2">
                                    <i class="fas fa-calendar text-blue-400 text-xs w-4"></i> Lihat Jadwal
                                </a>
                                {{-- <a href="{{ route('jadwal.dokumentasi') }}"
                                    class="w-full text-left px-4 py-2.5 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors flex items-center gap-2">
                                    <i class="fas fa-file-excel text-blue-400 text-xs w-4"></i> Dokumentasi
                                </a> --}}
                            </div>
                        </div>
                    @endif
                @endauth
                @guest
                    <a href="{{ route('jadwal.index') }}"
                        class="nav-link px-4 py-2 rounded-lg text-sm {{ Route::is('jadwal.*') ? 'nav-active text-blue-400' : 'text-gray-400' }} transition-all">
                        Jadwal
                    </a>
                @endguest

                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('arsip.index') }}"
                            class="nav-link px-4 py-2 rounded-lg text-sm {{ Route::is('arsip.*') ? 'nav-active text-blue-400' : 'text-gray-400' }} transition-all">
                            Arsip
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Right side -->
            <div class="flex items-center gap-3">
                <!-- Notification (static for now) -->
                <button
                    class="relative w-9 h-9 rounded-lg bg-navy-800 border border-navy-600 flex items-center justify-center text-gray-400 hover:text-white hover:border-blue-500 transition-all">
                    <i class="fas fa-bell text-sm"></i>
                    <span class="notif-dot"></span>
                </button>

                <!-- User Dropdown -->
                <div class="relative" id="userDropdownContainer">
                    <button onclick="toggleDropdown('userDropdown')"
                        class="flex items-center gap-3 pl-4 border-l border-navy-700">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-500/20 border border-blue-500/30 flex items-center justify-center text-xs font-700 text-blue-400 overflow-hidden">
                            @auth
                                @if (Auth::user()->role === 'admin')
                                    A
                                @endif
                            @endauth
                            @guest
                                G
                            @endguest
                        </div>
                        <div class="text-left hide-mobile">

                            @auth
                                <p class="text-xs font-700 text-white">
                                    @if (Auth::user()->role)
                                        Admin
                                    @endif()
                                </p>
                            @endauth
                            @guest
                                Guest
                            @endguest

                        </div>
                        <i class="fas fa-chevron-down text-xs text-gray-500 hide-mobile"></i>
                    </button>

                    <div id="userDropdown" class="dropdown-menu absolute top-12 right-0 w-48 py-2 hidden z-50"
                        style="background: #0f2040; border: 1px solid rgba(59,127,255,0.2); border-radius: 10px;">


                        <a href="#"
                            class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors flex items-center gap-2">
                            <i class="fas fa-user text-blue-400 text-xs w-4"></i> Profile
                        </a>
                        <a href="{{ route('settings.index') }}"
                            class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors flex items-center gap-2">
                            <i class="fas fa-cog text-blue-400 text-xs w-4"></i> Settings
                        </a>
                        @auth
                            <div class="border-t border-navy-700 my-1"></div>
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-navy-700 hover:text-red-300 transition-colors flex items-center gap-2">
                                    <i class="fas fa-sign-out-alt text-red-400 text-xs w-4"></i> Logout
                                </button>
                            </form>
                        @endauth

                        @guest
                            <div class="border-t border-navy-700 my-1"></div>
                            <a href="{{ route('login') }}"
                                class="w-full text-left px-4 py-2 text-sm text-teal-600 hover:bg-navy-700 hover:text-white transition-colors flex items-center gap-2">
                                <i class="fas fa-sign-in-alt text-teal-600 text-xs w-4"></i> Login Admin
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
    </nav>
</div>
