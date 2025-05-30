<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام طوارئ الحوادث</title>
    <!-- Bootstrap 5 RTL CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #dc3545;
            --secondary-color: #333;
            --accent-color: #ffc107;
        }
        
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f8f9fa;
        }
        
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1584942368913-1e5b8f1d7b0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            position: relative;
        }
        
        .feature-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .nav-pills .nav-link.active {
            background-color: var(--primary-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
        }
        
        .registration-form {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .user-type-btn {
            border: 2px solid #dee2e6;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .user-type-btn.active {
            border-color: var(--primary-color);
            background-color: rgba(220, 53, 69, 0.1);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }
        
        footer {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .social-icon {
            color: white;
            font-size: 1.5rem;
            margin: 0 10px;
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            color: var(--accent-color);
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-ambulance me-2"></i>نظام طوارئ الحوادث
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#about">عن النظام</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">المميزات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">الخدمات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">اتصل بنا</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-light" href="{{route('login')}}">تسجيل الدخول</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">سلامتك تهمنا... استجابتنا سريعة</h1>
                    <p class="lead mb-5">نظام متكامل للإبلاغ التلقائي عن الحوادث المرورية وتوجيه المساعدة الطبية بشكل فوري لإنقاذ الأرواح</p>
                    <a class="btn btn-primary btn-lg me-3" href="{{route('register')}}">إنشاء حساب جديد</a>
                    <a href="{{route('login')}}" class="btn btn-outline-light btn-lg">تسجيل الدخول</a>
                </div>
               
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1605296830685-7ecbd1aac9f9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Emergency System" class="img-fluid rounded shadow">
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">عن نظام طوارئ الحوادث</h2>
                    <p class="lead">حل متكامل يعتمد على التكنولوجيا الذكية لإنقاذ الأرواح</p>
                    <p>نظام طوارئ الحوادث هو حل متكامل يعتمد على التكنولوجيا الذكية للإبلاغ التلقائي عن الحوادث المرورية وتوجيه المساعدة الطبية بشكل فوري. يتكون النظام من جهاز يتم تركيبه في المركبة وموقع إلكتروني لإدارة البلاغات وتوجيه المساعدة.</p>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> استجابة سريعة للحوادث</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> تحديد الموقع بدقة عالية</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> توجيه المساعدة الطبية الفورية</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">مميزات النظام</h2>
                <p class="lead text-muted">أهم المميزات التي تجعل نظامنا الأفضل في مجال الطوارئ</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <h4 class="card-title">الإبلاغ التلقائي</h4>
                            <p class="card-text">يقوم الجهاز المثبت في المركبة بإرسال بلاغ تلقائي عند وقوع حادث، مما يوفر الوقت وينقذ الأرواح.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <h4 class="card-title">تحديد الموقع بدقة</h4>
                            <p class="card-text">يحدد النظام موقع الحادث بدقة باستخدام تقنية GPS لتوجيه فرق الإسعاف إلى المكان الصحيح.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h4 class="card-title">استجابة سريعة</h4>
                            <p class="card-text">يتواصل النظام مع أقرب مركز صحي متاح لتوفير المساعدة الطبية في أسرع وقت ممكن.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">خدماتنا</h2>
                <p class="lead text-muted">نقدم مجموعة متكاملة من الخدمات لضمان سلامتك</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-cogs text-primary mb-3" style="font-size: 2rem;"></i>
                            <h5 class="card-title">تركيب الأجهزة</h5>
                            <p class="card-text text-muted">تركيب أجهزة استشعار الحوادث في المركبات بمعايير عالية الجودة</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-headset text-primary mb-3" style="font-size: 2rem;"></i>
                            <h5 class="card-title">مراقبة الحوادث</h5>
                            <p class="card-text text-muted">مراقبة الحوادث على مدار الساعة وإرسال المساعدة الفورية</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-database text-primary mb-3" style="font-size: 2rem;"></i>
                            <h5 class="card-title">تحليل البيانات</h5>
                            <p class="card-text text-muted">توفير بيانات الحوادث للجهات المعنية لتحسين السلامة المرورية</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-graduation-cap text-primary mb-3" style="font-size: 2rem;"></i>
                            <h5 class="card-title">التدريب والدعم</h5>
                            <p class="card-text text-muted">دعم وتدريب المستخدمين على النظام وطرق الاستفادة منه</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    {{-- <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3">
                    <h3 class="fw-bold display-4">2,500+</h3>
                    <p class="lead">حوادث تم الإبلاغ عنها</p>
                </div>
                <div class="col-md-3">
                    <h3 class="fw-bold display-4">98%</h3>
                    <p class="lead">نسبة الاستجابة السريعة</p>
                </div>
                <div class="col-md-3">
                    <h3 class="fw-bold display-4">150+</h3>
                    <p class="lead">مركز صحي متعاون</p>
                </div>
                <div class="col-md-3">
                    <h3 class="fw-bold display-4">10,000+</h3>
                    <p class="lead">مستخدم مسجل</p>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Testimonials Section -->
    {{-- <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">آراء عملائنا</h2>
                <p class="lead text-muted">ما يقوله مستخدمونا عن تجربتهم مع النظام</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex mb-3">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="rounded-circle me-3" width="60" height="60" alt="User">
                                <div>
                                    <h5 class="mb-1">أحمد محمد</h5>
                                    <p class="text-muted mb-0">سائق</p>
                                </div>
                            </div>
                            <p class="card-text">"النظام أنقذ حياتي بعد حادث تعرضت له في منطقة نائية. تم إرسال المساعدة خلال دقائق بفضل التحديد الدقيق لموقعي."</p>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex mb-3">
                                <img src="https://randomuser.me/api/portraits/women/44.jpg" class="rounded-circle me-3" width="60" height="60" alt="User">
                                <div>
                                    <h5 class="mb-1">سارة عبدالله</h5>
                                    <p class="text-muted mb-0">مديرة مركز صحي</p>
                                </div>
                            </div>
                            <p class="card-text">"النظام ساعدنا في تحسين استجابتنا للحوادث بنسبة 40%. الآن نستطيع تحديد موقع الحادث بدقة وتوجيه الفرق الطبية بسرعة."</p>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex mb-3">
                                <img src="https://randomuser.me/api/portraits/men/75.jpg" class="rounded-circle me-3" width="60" height="60" alt="User">
                                <div>
                                    <h5 class="mb-1">خالد سعيد</h5>
                                    <p class="text-muted mb-0">مسؤول مرور</p>
                                </div>
                            </div>
                            <p class="card-text">"البيانات التي يوفرها النظام تساعدنا في تحديد النقاط السوداء وتحسين السلامة المرورية في مناطق الحوادث المتكررة."</p>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">اتصل بنا</h2>
                    <p class="lead">نحن هنا لمساعدتك في أي استفسار</p>
                    
                    <div class="d-flex align-items-start mb-4">
                        <i class="fas fa-map-marker-alt text-primary mt-1 me-3" style="font-size: 1.5rem;"></i>
                        <div>
                            <h5>العنوان</h5>
                            <p class="text-muted mb-0">صنعاء الجمهورية اليمنية </p>
                        </div>
                    </div>
                    
                    {{-- <div class="d-flex align-items-start mb-4">
                        <i class="fas fa-phone-alt text-primary mt-1 me-3" style="font-size: 1.5rem;"></i>
                        <div>
                            <h5>هاتف</h5>
                            <p class="text-muted mb-0">+967  777111333</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start mb-4">
                        <i class="fas fa-envelope text-primary mt-1 me-3" style="font-size: 1.5rem;"></i>
                        <div>
                            <h5>البريد الإلكتروني</h5>
                            <p class="text-muted mb-0">info@emergency-system.com</p>
                        </div>
                    </div> --}}
                </div>
                
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start mb-4">
                                <i class="fas fa-phone-alt text-primary mt-1 me-3" style="font-size: 1.5rem;"></i>
                                <div>
                                    <h5>هاتف</h5>
                                    <p class="text-muted mb-0">+967  777111333</p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-start mb-4">
                                <i class="fas fa-envelope text-primary mt-1 me-3" style="font-size: 1.5rem;"></i>
                                <div>
                                    <h5>البريد الإلكتروني</h5>
                                    <p class="text-muted mb-0">info@emergency-system.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="fw-bold mb-3"><i class="fas fa-ambulance me-2"></i>نظام طوارئ الحوادث</h5>
                    <p>نظام متكامل للإبلاغ التلقائي عن الحوادث المرورية وتوجيه المساعدة الطبية بشكل فوري لإنقاذ الأرواح.</p>
                    <div class="mt-4">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h5 class="fw-bold mb-3">روابط سريعة</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">الصفحة الرئيسية</a></li>
                        <li class="mb-2"><a href="#about" class="text-white text-decoration-none">عن النظام</a></li>
                        <li class="mb-2"><a href="#features" class="text-white text-decoration-none">المميزات</a></li>
                        <li class="mb-2"><a href="#services" class="text-white text-decoration-none">الخدمات</a></li>
                        <li class="mb-2"><a href="#contact" class="text-white text-decoration-none">اتصل بنا</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h5 class="fw-bold mb-3">خدماتنا</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">تركيب الأجهزة</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">مراقبة الحوادث</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">تحليل البيانات</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">التدريب والدعم</a></li>
                    </ul>
                </div>
                
               
            </div>
            
            <hr class="my-4 bg-light">
            
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">© 2025 نظام طوارئ الحوادث. جميع الحقوق محفوظة.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">تصميم وتطوير <a href="#" class="text-white text-decoration-none">فريق النظام</a></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Registration form toggle
            const registerBtn = document.getElementById('register-btn');
            const registrationForm = document.getElementById('registration-form');
            
            registerBtn.addEventListener('click', function(e) {
                e.preventDefault();
                registrationForm.style.display = registrationForm.style.display === 'block' ? 'none' : 'block';
            });
            
            // User type selection
            const userTypeBtns = document.querySelectorAll('.user-type-btn');
            const clientForm = document.getElementById('client-form');
            const centerForm = document.getElementById('center-form');
            
            userTypeBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    userTypeBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    if (this.dataset.type === 'client') {
                        clientForm.style.display = 'block';
                        centerForm.style.display = 'none';
                    } else {
                        clientForm.style.display = 'none';
                        centerForm.style.display = 'block';
                    }
                });
            });
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>