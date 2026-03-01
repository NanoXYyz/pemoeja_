{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bolu - @yield('title')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Bootstrap Icons (untuk kompatibilitas) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.min.css">

    <!-- FullCalendar -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.10/index.global.min.css" rel="stylesheet" />

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />

    <link rel="prefetch" href="content/dashboard">
    <link rel="prefetch" href="lagu/index">
    <link rel="prefetch" href="lagu/create">
    <link rel="prefetch" href="lagu/edit">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        navy: {
                            950: '#050d1a',
                            900: '#0a1628',
                            800: '#0f2040',
                            700: '#152a54',
                            600: '#1a3468',
                            500: '#1e3d7a',
                            400: '#2d5299',
                            300: '#4a72c4',
                            200: '#7799d4',
                            100: '#b3c7e8',
                        },
                        blue: {
                            accent: '#3b7fff',
                            bright: '#60a5fa',
                            glow: '#1d4ed8',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        }
    </script>

    <x-style />

    @stack('styles')
</head>


<body>

    <!-- ===== NAVBAR ===== -->
    {{-- <nav class="navbar-glass sticky top-0 z-50 px-4 md:px-8">
        <div class="max-w-7xl mx-auto flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <a href="/" wire:navigate class="font-black text-white text-lg tracking-tight">Pemoeja Bolu</a>
            </div>

            <!-- Nav Links -->
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('content.dashboard') }}" wire:navigate
                    class="nav-link px-4 py-2 rounded-lg text-sm {{ Route::is('content.dashboard') ? 'nav-active text-blue-400' : 'text-gray-400' }} transition-all">
                    Home
                </a>
                <a href="{{ route('anggota.index') }}" wire:navigate
                    class="nav-link px-4 py-2 rounded-lg text-sm {{ Route::is('anggota.*') ? 'nav-active text-blue-400' : 'text-gray-400' }} transition-all">
                    Anggota
                </a>

                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('keuangan.index') }}" wire:navigate
                            class="nav-link px-4 py-2 rounded-lg text-sm {{ Route::is('keuangan*') ? 'nav-active text-blue-400' : 'text-gray-400 hover:bg-navy-800 hover:text-white' }} transition-all">
                            Keuangan
                        </a>
                    @endif
                @endauth

                <!-- Lagu Dropdown -->
                @auth
                    @if (Auth::user()->role === 'admin')
                        <div class="relative" id="laguDropdownContainer">
                            <button onclick="toggleDropdown('laguDropdown')"
                                class="nav-link px-4 py-2 rounded-lg text-sm {{ Request::is('lagu*') ? 'nav-active text-blue-400' : 'text-gray-400 hover:bg-navy-800 hover:text-white' }} transition-all flex items-center gap-1">
                                Lagu <i class="fas fa-chevron-down text-xs opacity-60"></i>
                            </button>
                            <div id="laguDropdown" class="dropdown-menu absolute top-12 left-0 w-44 py-2 hidden z-50"
                                style="background: #0f2040; border: 1px solid rgba(59,127,255,0.2); border-radius: 10px;">
                                <a href="{{ route('lagu.index') }}" wire:navigate
                                    class="w-full text-left px-4 py-2.5 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors flex items-center gap-2">
                                    <i class="fas fa-music text-blue-400 text-xs w-4"></i> Lirik Lagu
                                </a>
                                <a href="{{ route('lagu.create') }}" wire:navigate
                                    class="w-full text-left px-4 py-2.5 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors flex items-center gap-2">
                                    <i class="fas fa-plus-circle text-blue-400 text-xs w-4"></i> Pengaturan Lagu
                                </a>
                            </div>
                        </div>
                    @endif
                @endauth
                @guest
                    <a href="{{ route('lagu.index') }}" wire:navigate
                        class="nav-link px-4 py-2 rounded-lg text-sm {{ Route::is('lagu.*') ? 'nav-active text-blue-400' : 'text-gray-400' }} transition-all">
                        Lagu
                    </a>
                @endguest

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
                                <a href="{{ route('jadwal.index') }}" wire:navigate
                                    class="w-full text-left px-4 py-2.5 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors flex items-center gap-2">
                                    <i class="fas fa-calendar text-blue-400 text-xs w-4"></i> Lihat Jadwal
                                </a>
                                <a href="{{ route('jadwal.dokumentasi') }}" wire:navigate
                                    class="w-full text-left px-4 py-2.5 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors flex items-center gap-2">
                                    <i class="fas fa-file-excel text-blue-400 text-xs w-4"></i> Dokumentasi
                                </a>
                            </div>
                        </div>
                    @endif
                @endauth
                @guest
                    <a href="{{ route('jadwal.index') }}" wire:navigate
                        class="nav-link px-4 py-2 rounded-lg text-sm {{ Route::is('jadwal.*') ? 'nav-active text-blue-400' : 'text-gray-400' }} transition-all">
                        Jadwal
                    </a>
                @endguest

                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('arsip.index') }}" wire:navigate
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
                        <div class="px-4 py-2 border-b border-navy-700 mb-1">
                            @auth
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    @if (Auth::user()->role)
                                        Admin
                                    @endif()
                                </span>
                            @endauth
                            @guest
                                Guest
                            @endguest
                        </div>

                        <a href="#"
                            class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors flex items-center gap-2">
                            <i class="fas fa-user text-blue-400 text-xs w-4"></i> Profile
                        </a>
                        <a href="/settings" wire:navigate
                            class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors flex items-center gap-2">
                            <i class="fas fa-cog text-blue-400 text-xs w-4"></i> Settings
                        </a>
                        @auth
                            <div class="border-t border-navy-700 my-1"></div>
                            <form action="{{ route('logout') }}" wire:navigate method="POST" class="block">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-navy-700 hover:text-red-300 transition-colors flex items-center gap-2">
                                    <i class="fas fa-sign-out-alt text-red-400 text-xs w-4"></i> Logout
                                </button>
                            </form>
                        @endauth

                        @guest
                            <a href="{{ route('login') }}" wire:navigate
                                class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors flex items-center gap-2">
                                <i class="fas fa-sign-in-alt text-blue-400 text-xs w-4"></i> Login Admin
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
    </nav> --}}

    <x-navbar />

    <!-- ===== MAIN CONTENT ===== -->
    <main class="pt-10">
        <div class="max-w-7xl mx-auto px-4 md:px-8 py-8">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <x-footer />

    <!-- SCRIPTS -->
    <x-script />
    {{-- <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <script>
        // Dropdown functionality
        function toggleDropdown(id) {
            const el = document.getElementById(id);
            const isHidden = el.classList.contains('hidden');
            closeDropdowns();
            if (isHidden) el.classList.remove('hidden');
        }

        function closeDropdowns() {
            ['laguDropdown', 'jadwalDropdown', 'userDropdown'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.classList.add('hidden');
            });
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('[id$="DropdownContainer"]') && !e.target.closest('[id$="Container"]')) {
                closeDropdowns();
            }
        });


        // DataTable initialization
        $(document).ready(function() {
            if ($('#anggota').length) {
                $('#anggota').DataTable({
                    pageLength: 10,
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        infoEmpty: "Tidak ada data",
                        paginate: {
                            first: "«",
                            last: "»",
                            next: "›",
                            previous: "‹"
                        }
                    }
                });
            }
            if ($('#arsip').length) {
                $('#arsip').DataTable({
                    pageLength: 10,
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        infoEmpty: "Tidak ada data",
                        paginate: {
                            first: "«",
                            last: "»",
                            next: "›",
                            previous: "‹"
                        }
                    }
                });
            }
        });
    </script> --}}
</body>

</html>
