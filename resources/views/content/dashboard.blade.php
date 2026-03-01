{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Hero Section -->
    <section class="hero-bg rounded-2xl overflow-hidden mb-8 border border-navy-700">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 min-h-80">
            <!-- Left -->
            <div class="p-10 flex flex-col justify-center">
                <h1 class="text-4xl md:text-5xl font-900 leading-tight mb-4">
                    <span class="text-white">Welcome</span><br>
                    <span class="text-white">to Website </span><span class="grad-text">Pemoeja Bolu</span>
                </h1>
                <p class="text-gray-400 text-base mb-8 leading-relaxed max-w-md">
                    Kelola jadwal, anggota, dan keuangan dalam satu platform terpadu. Pengalaman kolaborasi yang
                    efisien dan terorganisir.
                </p>
                <!-- Social Media -->
                <div class="flex items-center justify-left gap-4">
                    <a href="#"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg bg-navy-800 border border-navy-600 text-gray-400 hover:border-blue-500 hover:text-white transition-all text-sm font-500">
                        <i class="fab fa-github"></i> GitHub
                    </a>
                    <a href="#"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg bg-navy-800 border border-navy-600 text-gray-400 hover:border-pink-500 hover:text-pink-400 transition-all text-sm font-500">
                        <i class="fab fa-instagram"></i> Instagram
                    </a>
                    <a href="#"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg bg-navy-800 border border-navy-600 text-gray-400 hover:border-red-500 hover:text-red-400 transition-all text-sm font-500">
                        <i class="fab fa-youtube"></i> YouTube
                    </a>
                </div>
            </div>
            <!-- Right - Static image for now -->
            <div class="relative bg-navy-900 overflow-hidden min-h-64">
                <div class="slide active absolute inset-0">
                    <img src="{{ asset('img') }}/bolu1.jpg" alt="bolu 1">
                </div>
                <div class="slide absolute inset-0">
                    <img src="{{ asset('img') }}/bolu2.jpg" alt="bolu 2">
                </div>
                <div class="slide absolute inset-0">
                    <img src="{{ asset('img') }}/bolu3.jpg" alt="bolu 3">
                </div>
                <div class="slide absolute inset-0">
                    <img src="{{ asset('img') }}/bolu4.jpg" alt="bolu 4">
                </div>
                <div class="slide absolute inset-0">
                    <img src="{{ asset('img') }}/bolu5.jpg" alt="bolu 5">
                </div>
                <div class="slide absolute inset-0">
                    <img src="{{ asset('img') }}/bolu6.jpg" alt="bolu 6">
                </div>
                <div class="slide absolute inset-0">
                    <img src="{{ asset('img') }}/bolu7.jpg" alt="bolu 7">
                </div>

                <!-- Slide dots -->
                <div class="absolute bottom-6 left-0 right-0 flex justify-center gap-3 z-20">
                    <div class="slide-dot active" onclick="goSlide(0)"></div>
                    <div class="slide-dot" onclick="goSlide(1)"></div>
                    <div class="slide-dot" onclick="goSlide(2)"></div>
                    <div class="slide-dot" onclick="goSlide(3)"></div>
                    <div class="slide-dot" onclick="goSlide(4)"></div>
                    <div class="slide-dot" onclick="goSlide(5)"></div>
                    <div class="slide-dot" onclick="goSlide(6)"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-gray-400 text-xs font-600 uppercase tracking-wider">Total Anggota</span>
                <div class="w-8 h-8 rounded-lg bg-blue-500/15 flex items-center justify-center">
                    <i class="fas fa-users text-blue-400 text-sm"></i>
                </div>
            </div>
            <p class="text-3xl font-900 text-white mb-1">{{ $totalAnggota }}</p>
            <p class="text-green-400 text-xs font-600"><i class="fas fa-arrow-up text-xs"></i> +12% bulan ini</p>
        </div>
        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-gray-400 text-xs font-600 uppercase tracking-wider">Total Keuangan</span>
                <div class="w-8 h-8 rounded-lg bg-green-500/15 flex items-center justify-center">
                    <i class="fas fa-wallet text-green-400 text-sm"></i>
                </div>
            </div>
            <p class="text-2xl font-900 text-white mb-1">Rp{{ number_format($saldoAkhir, 0, ',', '.') }}</p>
            <p class="text-green-400 text-xs font-600"><i class="fas fa-arrow-up text-xs"></i> +5.4% bulan ini</p>
        </div>
        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-gray-400 text-xs font-600 uppercase tracking-wider">Total Lagu</span>
                <div class="w-8 h-8 rounded-lg bg-red-500/15 flex items-center justify-center">
                    <i class="fas fa-music text-red-400 text-sm"></i>
                </div>
            </div>
            <p class="text-3xl font-900 text-white mb-1">{{ $totalLagu }}</p>
            <p class="text-gray-500 text-xs font-600">— tidak ada perubahan</p>
        </div>
        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-gray-400 text-xs font-600 uppercase tracking-wider">Arsip Files</span>
                <div class="w-8 h-8 rounded-lg bg-yellow-500/15 flex items-center justify-center">
                    <i class="fas fa-folder text-yellow-400 text-sm"></i>
                </div>
            </div>
            <p class="text-3xl font-900 text-white mb-1">{{ $totalArsip }}</p>
            <p class="text-green-400 text-xs font-600"><i class="fas fa-arrow-up text-xs"></i> +8% bulan ini</p>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h5 class="text-white font-bold flex items-center gap-2">
                    <i class="fas fa-user-tag text-blue-500"></i> Distribusi Status
                </h5>
                <span
                    class="text-[10px] bg-blue-500/10 text-blue-400 px-2 py-1 rounded-md uppercase font-bold tracking-wider">Pekerjaan</span>
            </div>
            <div class="relative h-[300px]">
                <canvas id="chartStatus"></canvas>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-6">
                <div class="bg-slate-800/40 p-3 rounded-xl border border-slate-700/50">
                    <p class="text-slate-400 text-xs mb-1 text-center uppercase tracking-tighter">Laki-laki</p>
                    <p class="text-white text-xl font-black text-center">{{ $dataGender['laki'] }}</p>
                </div>
                <div class="bg-slate-800/40 p-3 rounded-xl border border-slate-700/50">
                    <p class="text-slate-400 text-xs mb-1 text-center uppercase tracking-tighter">Perempuan</p>
                    <p class="text-white text-xl font-black text-center">{{ $dataGender['perempuan'] }}</p>
                </div>
            </div>
        </div>

        <!-- Financial Donut -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-700 text-white text-base">Alokasi Keuangan</h3>
                    <p class="text-gray-500 text-xs mt-1">Distribusi anggaran per kategori</p>
                </div>
                <button class="text-gray-500 hover:text-white text-sm"><i class="fas fa-ellipsis-h"></i></button>
            </div>
            <div class="flex items-center gap-8">
                <div class="relative flex-shrink-0">
                    <canvas id="financeChart" width="160" height="160"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-2xl font-900 text-white">60%</span>
                        <span class="text-xs text-gray-500">Operations</span>
                    </div>
                </div>
                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                        <span class="text-sm text-gray-300">Operations</span>
                        <span class="ml-auto text-sm font-700 text-white">60%</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                        <span class="text-sm text-gray-300">Events</span>
                        <span class="ml-auto text-sm font-700 text-white">20%</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-gray-600"></div>
                        <span class="text-sm text-gray-300">Savings</span>
                        <span class="ml-auto text-sm font-700 text-white">20%</span>
                    </div>
                    <div class="mt-2 pt-3 border-t border-navy-700">
                        <p class="text-xs text-gray-500">Total Budget</p>
                        <p class="text-base font-800 text-white">Rp 105.000.000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tech Stack -->
    <div class="card p-8 mb-8 text-center">
        <h3 class="text-gray-400 text-sm font-700 uppercase tracking-widest mb-8">Powered by Modern Technology</h3>
        <div class="flex items-center justify-center gap-10 flex-wrap">
            <div class="flex flex-col items-center gap-2 group">
                <div
                    class="w-14 h-14 rounded-xl bg-navy-800 border border-navy-600 flex items-center justify-center group-hover:border-blue-500 transition-all">
                    <i class="fab fa-php text-indigo-400 text-2xl"></i>
                </div>
                <span class="text-xs text-gray-500 group-hover:text-white transition-colors">PHP</span>
            </div>
            <div class="flex flex-col items-center gap-2 group">
                <div
                    class="w-14 h-14 rounded-xl bg-navy-800 border border-navy-600 flex items-center justify-center group-hover:border-blue-500 transition-all">
                    <i class="fab fa-laravel text-red-400 text-2xl"></i>
                </div>
                <span class="text-xs text-gray-500 group-hover:text-white transition-colors">Laravel</span>
            </div>
            <div class="flex flex-col items-center gap-2 group">
                <div
                    class="w-14 h-14 rounded-xl bg-navy-800 border border-navy-600 flex items-center justify-center group-hover:border-blue-500 transition-all">
                    <i class="fas fa-wind text-cyan-400 text-2xl"></i>
                </div>
                <span class="text-xs text-gray-500 group-hover:text-white transition-colors">Tailwind</span>
            </div>
            <div class="flex flex-col items-center gap-2 group">
                <div
                    class="w-14 h-14 rounded-xl bg-navy-800 border border-navy-600 flex items-center justify-center group-hover:border-blue-500 transition-all">
                    <i class="fab fa-js text-yellow-400 text-2xl"></i>
                </div>
                <span class="text-xs text-gray-500 group-hover:text-white transition-colors">jQuery</span>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.slide-dot');
        let slideInterval;

        function showSlide(n) {
            // Reset indeks jika melebihi jumlah slide
            if (n >= slides.length) currentSlide = 0;
            if (n < 0) currentSlide = slides.length - 1;

            // Hilangkan class active dari semua slide dan dots
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            // Tambahkan class active pada slide yang dipilih
            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        }

        function goSlide(n) {
            currentSlide = n;
            showSlide(currentSlide);
            resetTimer(); // Reset waktu otomatis saat user mengklik manual
        }

        function nextSlide() {
            currentSlide++;
            showSlide(currentSlide);
        }

        function resetTimer() {
            clearInterval(slideInterval);
            slideInterval = setInterval(nextSlide, 5000); // Ganti slide setiap 5 detik
        }

        // Jalankan auto-slide pertama kali
        resetTimer();
    </script>
    // Member Chart
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Konfigurasi Global
        Chart.defaults.color = '#94a3b8'; // Slate 400
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

        // --- 1. Chart Status (Bar Chart dengan Gradien) ---
        const ctxStatus = document.getElementById('chartStatus').getContext('2d');

        // Buat Gradien Biru
        const blueGrad = ctxStatus.createLinearGradient(0, 0, 0, 400);
        blueGrad.addColorStop(0, '#3b82f6'); // blue-500
        blueGrad.addColorStop(1, '#1d4ed8'); // blue-700

        // Buat Gradien Hijau/Emerald
        const greenGrad = ctxStatus.createLinearGradient(0, 0, 0, 400);
        greenGrad.addColorStop(0, '#10b981'); // emerald-500
        greenGrad.addColorStop(1, '#047857'); // emerald-700

        new Chart(ctxStatus, {
            type: 'bar',
            data: {
                labels: ['Laki-Laki', 'Perempuan'],
                datasets: [{
                    data: [{{ $dataGender['laki'] }}, {{ $dataGender['perempuan'] }}],
                    backgroundColor: [blueGrad, greenGrad],
                    borderRadius: 12,
                    borderSkipped: false,
                    barPercentage: 0.6,
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                weight: 'bold',
                                size: 11
                            }
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(255,255,255,0.05)'
                        },
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Finance Chart
        const financeChartCtx = document.getElementById('financeChart');
        if (financeChartCtx) {
            new Chart(financeChartCtx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [60, 20, 20],
                        backgroundColor: ['#3b7fff', '#8b5cf6', '#374151'],
                        borderWidth: 0,
                        hoverOffset: 4,
                        borderRadius: 4,
                    }]
                },
                options: {
                    cutout: '75%',
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    responsive: false,
                }
            });
        }
    </script>
@endpush
