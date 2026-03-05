<div>
    <!-- SCRIPTS -->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
            if ($('#lagu').length) {
                $('#lagu').DataTable({
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
    </script>

    @stack('scripts')
    {{-- <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>

    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>

    <script src="{{ asset('template/vendor/chart.js/Chart.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Tabel
            if ($('#anggota').length) {
                new DataTable('#anggota');
            }
            if ($('#arsip').length) {
                new DataTable('#arsip');
            }
        });

        // ===========================
        // SLIDER (HOME)
        // ===========================
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.slide-dot');

        function goSlide(n) {
            slides.forEach(s => s.classList.remove('active'));
            dots.forEach(d => d.classList.remove('active'));
            currentSlide = n;
            slides[n].classList.add('active');
            dots[n].classList.add('active');
        }

        setInterval(() => {
            goSlide((currentSlide + 1) % slides.length);
        }, 4000);
    </script> --}}
</div>
