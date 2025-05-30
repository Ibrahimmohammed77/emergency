<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>لوحة التحكم | {{ config('app.name', 'نظام الطوارئ') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    @yield('styles')
</head>
<body class="sb-nav-fixed">
    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">نظام الطوارئ - لوحة التحكم</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 ms-auto" id="sidebarToggle" href="#!">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Navbar -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user fa-fw"></i> {{ auth('admin')->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.profile') }}">الملف الشخصي</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

    <div id="layoutSidenav">
        <!-- Sidebar -->
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            لوحة التحكم
                        </a>

                        {{-- <a class="nav-link" href="{{ route('admin.admins.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users-cog"></i></div>
                            المشرفون
                        </a> --}}
                        <a class="nav-link" href="{{ route('admin.users.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            المستخدمون
                        </a>
                        <a class="nav-link" href="{{ route('admin.medical-centers.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-hospital"></i></div>
                            المراكز الطبية
                        </a>
                        <a class="nav-link" href="{{ route('admin.accidents.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-car-crash"></i></div>
                            الحوادث
                        </a>
                    </div>
                </div>
               
            </nav>
        </div>

        <!-- Main Content -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    @yield('content')
                </div>
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
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('js/admin.js') }}"></script>

    <!-- RTL DataTables language -->
    <script>
        $(document).ready(function() {
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