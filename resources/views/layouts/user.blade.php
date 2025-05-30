<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'نظام الطوارئ') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">

    @yield('styles')
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('user.dashboard') }}">
                <i class="fas fa-ambulance ms-2"></i> {{ config('app.name', 'نظام الطوارئ') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.dashboard') }}"><i class="fas fa-home ms-2"></i> لوحة التحكم</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.vehicles.index') }}"><i class="fas fa-car ms-2"></i> مركباتي</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.accidents.index') }}"><i class="fas fa-car-crash ms-2"></i> سجل الحوادث</a>
                    </li>
                </ul>

                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle ms-2"></i> {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-start shadow">
                                <a class="dropdown-item" href="{{ route('user.profile') }}">
                                    <i class="fas fa-user ms-2"></i> الملف الشخصي
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt ms-2"></i> تسجيل الخروج
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt ms-2"></i> تسجيل الدخول</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus ms-2"></i> تسجيل جديد</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-primary text-white text-center py-3 mt-4">
        <p class="mb-0">جميع الحقوق محفوظة &copy; {{ date('Y') }} نظام الطوارئ</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/user.js') }}"></script>

    <script>
        // RTL specific adjustments
        $(document).ready(function() {
            // Adjust form controls for RTL
            $('input, textarea, select').css('text-align', 'right');
            
            // Adjust dropdown menu positioning
            $('.dropdown-menu').addClass('dropdown-menu-start');
            
            // Adjust all margin/padding utilities that use left/right
            $('.me-').removeClass('me-').addClass('ms-');
        });
    </script>

    @yield('scripts')
</body>
</html>