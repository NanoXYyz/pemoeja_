<div>

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

        <style>
            * {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }

            body {
                background: #050d1a;
                color: #e2eaf5;
            }

            /* Scrollbar */
            ::-webkit-scrollbar {
                width: 6px;
            }

            ::-webkit-scrollbar-track {
                background: #0a1628;
            }

            ::-webkit-scrollbar-thumb {
                background: #1a3468;
                border-radius: 3px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #3b7fff;
            }

            /* Navbar */
            .navbar-glass {
                background: rgba(10, 22, 40, 0.95);
                backdrop-filter: blur(20px);
                border-bottom: 1px solid rgba(59, 127, 255, 0.15);
            }

            /* Cards */
            .card {
                background: #0f2040;
                border: 1px solid rgba(59, 127, 255, 0.12);
                border-radius: 12px;
            }

            .card-hover:hover {
                border-color: rgba(59, 127, 255, 0.35);
                transform: translateY(-2px);
                transition: all 0.3s;
            }

            /* Glow effects */
            .glow-blue {
                box-shadow: 0 0 20px rgba(59, 127, 255, 0.3);
            }

            .glow-blue-sm {
                box-shadow: 0 0 10px rgba(59, 127, 255, 0.2);
            }

            .text-glow {
                text-shadow: 0 0 20px rgba(59, 127, 255, 0.5);
            }

            /* Gradient text */
            .grad-text {
                background: linear-gradient(135deg, #60a5fa 0%, #3b7fff 50%, #a78bfa 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .grad-text-2 {
                background: linear-gradient(135deg, #e2eaf5 0%, #93c5fd 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            /* Buttons */
            .btn-primary {
                background: linear-gradient(135deg, #1d4ed8, #3b7fff);
                border: 1px solid rgba(59, 127, 255, 0.4);
                color: white;
                padding: 10px 20px;
                border-radius: 8px;
                font-weight: 600;
                font-size: 0.875rem;
                cursor: pointer;
                transition: all 0.25s;
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, #2563eb, #60a5fa);
                box-shadow: 0 0 20px rgba(59, 127, 255, 0.4);
            }

            .btn-secondary {
                background: rgba(30, 61, 122, 0.3);
                border: 1px solid rgba(59, 127, 255, 0.2);
                color: #93c5fd;
                padding: 8px 16px;
                border-radius: 8px;
                font-size: 0.875rem;
                cursor: pointer;
                transition: all 0.2s;
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }

            .btn-secondary:hover {
                background: rgba(59, 127, 255, 0.15);
                border-color: rgba(59, 127, 255, 0.4);
                color: white;
            }

            .btn-danger {
                background: rgba(239, 68, 68, 0.1);
                border: 1px solid rgba(239, 68, 68, 0.25);
                color: #f87171;
                padding: 6px 12px;
                border-radius: 6px;
                font-size: 0.75rem;
                cursor: pointer;
                transition: all 0.2s;
            }

            .btn-danger:hover {
                background: rgba(239, 68, 68, 0.2);
            }

            /* Form inputs */
            .form-input,
            .form-select,
            .form-textarea {
                background: #0a1628;
                border: 1px solid rgba(59, 127, 255, 0.2);
                color: #e2eaf5;
                border-radius: 8px;
                padding: 10px 14px;
                width: 100%;
                font-size: 0.875rem;
                outline: none;
                transition: border-color 0.2s;
            }

            .form-input:focus,
            .form-select:focus,
            .form-textarea:focus {
                border-color: #3b7fff;
                box-shadow: 0 0 0 3px rgba(59, 127, 255, 0.1);
            }

            .form-input::placeholder {
                color: #4a72c4;
            }

            .form-select option {
                background: #0f2040;
            }

            label {
                display: block;
                font-size: 0.8rem;
                font-weight: 600;
                color: #7799d4;
                margin-bottom: 6px;
                letter-spacing: 0.05em;
                text-transform: uppercase;
            }

            /* Stat cards */
            .stat-card {
                background: linear-gradient(135deg, #0f2040, #152a54);
                border: 1px solid rgba(59, 127, 255, 0.15);
                border-radius: 12px;
                padding: 24px;
                position: relative;
                overflow: hidden;
                transition: all 0.3s;
            }

            .stat-card::before {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                width: 80px;
                height: 80px;
                background: radial-gradient(circle, rgba(59, 127, 255, 0.15), transparent);
                border-radius: 50%;
            }

            .stat-card:hover {
                border-color: rgba(59, 127, 255, 0.3);
                transform: translateY(-3px);
            }

            /* Nav active */
            .nav-active {
                color: #60a5fa !important;
                position: relative;
            }

            .nav-active::after {
                content: '';
                position: absolute;
                bottom: -4px;
                left: 0;
                right: 0;
                height: 2px;
                background: #3b7fff;
                border-radius: 2px;
                box-shadow: 0 0 6px #3b7fff;
            }

            /* Page sections */
            .page {
                display: none;
                animation: fadeIn 0.3s ease;
            }

            .page.active {
                display: block;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(8px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Badge */
            .badge {
                display: inline-flex;
                align-items: center;
                padding: 3px 10px;
                border-radius: 50px;
                font-size: 0.7rem;
                font-weight: 700;
                letter-spacing: 0.04em;
            }

            .badge-blue {
                background: rgba(59, 127, 255, 0.15);
                color: #93c5fd;
                border: 1px solid rgba(59, 127, 255, 0.25);
            }

            .badge-green {
                background: rgba(34, 197, 94, 0.1);
                color: #86efac;
                border: 1px solid rgba(34, 197, 94, 0.2);
            }

            .badge-red {
                background: rgba(239, 68, 68, 0.1);
                color: #fca5a5;
                border: 1px solid rgba(239, 68, 68, 0.2);
            }

            .badge-yellow {
                background: rgba(234, 179, 8, 0.1);
                color: #fde047;
                border: 1px solid rgba(234, 179, 8, 0.2);
            }

            .badge-pink {
                background: rgba(236, 72, 153, 0.1);
                color: #f9a8d4;
                border: 1px solid rgba(236, 72, 153, 0.2);
            }

            /* Table */
            .data-table {
                width: 100%;
                border-collapse: collapse;
            }

            .data-table thead tr {
                border-bottom: 1px solid rgba(59, 127, 255, 0.15);
            }

            .data-table thead th {
                padding: 12px 16px;
                text-align: left;
                font-size: 0.7rem;
                font-weight: 700;
                color: #4a72c4;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .data-table tbody tr {
                border-bottom: 1px solid rgba(15, 32, 64, 0.5);
                transition: background 0.15s;
            }

            .data-table tbody tr:hover {
                background: rgba(59, 127, 255, 0.05);
            }

            .data-table tbody td {
                padding: 12px 16px;
                font-size: 0.875rem;
            }

            /* Notification dot */
            .notif-dot {
                position: absolute;
                top: 2px;
                right: 2px;
                width: 8px;
                height: 8px;
                background: #ef4444;
                border-radius: 50%;
                border: 2px solid #050d1a;
            }

            /* Datatable overrides */
            .dataTables_wrapper .dataTables_length select,
            .dataTables_wrapper .dataTables_filter input {
                background: #0a1628 !important;
                border: 1px solid rgba(59, 127, 255, 0.2) !important;
                color: #e2eaf5 !important;
                border-radius: 6px;
                padding: 4px 8px;
                outline: none;
            }

            .dataTables_wrapper .dataTables_info {
                color: #4a72c4 !important;
                font-size: 0.75rem;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button {
                background: rgba(30, 61, 122, 0.3) !important;
                border: 1px solid rgba(59, 127, 255, 0.1) !important;
                color: #93c5fd !important;
                border-radius: 6px !important;
                margin: 2px !important;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background: #1d4ed8 !important;
                color: white !important;
            }

            /* Section header */
            .section-header {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 24px;
            }

            .section-icon {
                width: 40px;
                height: 40px;
                border-radius: 10px;
                background: linear-gradient(135deg, #1d4ed8, #3b7fff);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1rem;
                box-shadow: 0 0 12px rgba(59, 127, 255, 0.3);
            }

            /* Progress bar */
            .progress-bar {
                height: 4px;
                background: rgba(59, 127, 255, 0.15);
                border-radius: 2px;
                overflow: hidden;
            }

            .progress-fill {
                height: 100%;
                background: linear-gradient(to right, #1d4ed8, #60a5fa);
                border-radius: 2px;
            }

            /* Toggle switch */
            .toggle {
                position: relative;
                display: inline-block;
                width: 40px;
                height: 22px;
            }

            .toggle input {
                opacity: 0;
                width: 0;
                height: 0;
            }

            .toggle .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: #1a3468;
                border-radius: 22px;
                transition: 0.3s;
            }

            .toggle .slider:before {
                position: absolute;
                content: "";
                height: 16px;
                width: 16px;
                left: 3px;
                bottom: 3px;
                background: #4a72c4;
                border-radius: 50%;
                transition: 0.3s;
            }

            .toggle input:checked+.slider {
                background: #1d4ed8;
            }

            .toggle input:checked+.slider:before {
                transform: translateX(18px);
                background: white;
            }

            /* Mengatur agar gambar memenuhi container dan transisi halus */
            ..slide {
        opacity: 0;
        transition: opacity 0.8s ease-in-out;
        width: 100%;
        height: 100%;
    }
    .slide.active {
        opacity: 1;
    }
    .slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Styling Titik-Titik (Dots) */
    .slide-dot {
        width: 12px;
        height: 12px;
        border-radius: 99px;
        background-color: rgba(255, 255, 255, 0.3);
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .slide-dot:hover {
        background-color: rgba(255, 255, 255, 0.6);
        transform: scale(1.2);
    }

    .slide-dot.active {
        background-color: #3b82f6; /* Warna biru primary */
        width: 30px; /* Membuat titik yang aktif lebih panjang (pill shape) */
        box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
    }
    
    /* Overlay agar tulisan/titik lebih mudah dibaca di atas gambar terang */
    .hero-bg .relative::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.5), transparent);
        pointer-events: none;
    }
        </style>
        <style>
    /* Reset FullCalendar Border & Colors */
    .fc { --fc-border-color: rgba(255,255,255,0.05); --fc-button-bg-color: #1e293b; --fc-button-border-color: #334155; }
    
    .fc .fc-toolbar-title { font-size: 1.25rem !important; font-weight: 800; color: white; }
    
    /* Header Days (Sen, Sel, etc) */
    .fc .fc-col-header-cell { background: rgba(30, 41, 59, 0.5); padding: 10px 0; }
    .fc .fc-col-header-cell-cushion { color: #94a3b8 !important; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; }

    /* Day Grid */
    .fc-daygrid-day-number { color: #94a3b8; font-weight: 600; padding: 8px !important; }
    .fc-day-today { background: rgba(59, 130, 246, 0.05) !important; }
    .fc-day-today .fc-daygrid-day-number { color: #3b82f6; font-weight: 900; }

    /* Event Style */
    .fc-event { background: #3b82f6 !important; border: none !important; padding: 2px 5px; border-radius: 4px !important; font-size: 0.7rem; cursor: pointer; transition: all 0.2s; }
    .fc-event:hover { transform: scale(1.02); filter: brightness(1.2); }

    /* Button Styling */
    .fc .fc-button-primary { background: #1e293b; border: 1px solid #334155; text-transform: capitalize; font-size: 0.8rem; }
    .fc .fc-button-primary:hover { background: #334155; }
    .fc .fc-button-active { background: #3b82f6 !important; border-color: #3b82f6 !important; }
</style>

        @stack('styles')
    </head>
</div>
