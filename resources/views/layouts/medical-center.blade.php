<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>المركز الطبي | {{ config('app.name', 'نظام الطوارئ') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="{{ asset('css/medical-center.css') }}" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

    @yield('styles')
</head>

<body class="">
    <!-- Navbar -->
    <nav class="navbar navbar-expand bg-dark shadow-sm">
        <div class="container-fluid text-white">
            <a class="navbar-brand d-flex text-white align-items-center text-decoration-none"
                href="{{ route('medical-center.dashboard') }}">
                <i class="fas fa-hospital ms-2 text-white"></i>
                <span class="fw-bold text-white">المركز الطبي</span>
            </a>

            <!-- Navbar Dropdown -->
            <ul class="navbar-nav me-auto text-white">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-decoration-none"
                        id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-user fa-fw ms-2 text-white"></i>
                        <span class="d-none d-md-inline text-white">{{ auth('medical_center')->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu text-white dropdown-menu-dark dropdown-menu-start"
                        aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item text-white" href="{{ route('medical-center.profile') }}">الملف الشخصي</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-white" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                تسجيل الخروج
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark bg-gradient" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading text-uppercase small text-muted">الأساسيات</div>
                        <a class="nav-link d-flex align-items-center" href="{{ route('medical-center.dashboard') }}">
                            <div class="sb-nav-link-icon ms-2" data-bs-toggle="tooltip" title="لوحة التحكم">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            لوحة التحكم
                        </a>

                        <div class="sb-sidenav-menu-heading text-uppercase small text-muted">حالات الطوارئ</div>
                        <a class="nav-link d-flex align-items-center" href="{{ route('medical-center.accidents') }}">
                            <div class="sb-nav-link-icon ms-2" data-bs-toggle="tooltip" title="جميع الحالات">
                                <i class="fas fa-car-crash"></i>
                            </div>
                            جميع الحالات
                        </a>
                        <a class="nav-link d-flex align-items-center"
                            href="{{ route('medical-center.accidents') }}?status=pending">
                            <div class="sb-nav-link-icon ms-2" data-bs-toggle="tooltip" title="الحالات المعلقة">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            الحالات المعلقة
                        </a>
                        <a class="nav-link d-flex align-items-center"
                            href="{{ route('medical-center.accidents') }}?status=processing">
                            <div class="sb-nav-link-icon ms-2" data-bs-toggle="tooltip" title="الحالات النشطة">
                                <i class="fas fa-ambulance"></i>
                            </div>
                            الحالات النشطة
                        </a>

                        <div class="sb-sidenav-menu-heading text-uppercase small text-muted">الإدارة</div>
                        <a class="nav-link d-flex align-items-center" href="{{ route('medical-center.profile') }}">
                            <div class="sb-nav-link-icon ms-2" data-bs-toggle="tooltip" title="ملف المركز">
                                <i class="fas fa-hospital-user"></i>
                            </div>
                            ملف المركز
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div id="layoutSidenav_content">
        <main>
            @yield('content')
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">جميع الحقوق محفوظة &copy; {{ config('app.name') }} {{ date('Y') }}</div>
                    <div>
                        <a href="#">سياسة الخصوصية</a>
                        &middot;
                        <a href="#">الشروط والأحكام</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="{{ asset('js/medical-center.js') }}"></script>

    <!-- RTL DataTables language -->
    <script>
        $(document).ready(function() {
            // Enable tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Set RTL for DataTables
            $.extend(true, $.fn.dataTable.defaults, {
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json"
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>