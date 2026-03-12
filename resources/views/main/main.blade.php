
<!doctype html>
<html lang="en" dir="ltr">

    <head>
        <meta charset="utf-8">
        <title>Certiactivo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Firma electrónica">
        <meta name="keywords" content="Obtén tu firma electrónica">
        <meta name="author" content="Certiactivo">
        <meta name="website" content="https://app.certiactivo.com">

        <!-- favicon -->
        <link rel="shortcut icon" href="{{asset('logo.png')}}">

        <!-- Css -->
        <link href="{{asset('b/assets/libs/tiny-slider/tiny-slider.css')}}" rel="stylesheet">
        <link href="{{asset('b/assets/libs/tobii/css/tobii.min.css')}}" rel="stylesheet">
        <!-- Bootstrap Css -->
        <link href="{{asset('b/assets/css/bootstrap.min.css')}}" id="bootstrap-style" class="theme-opt" rel="stylesheet" type="text/css">
        <!-- Icons Css -->
        <link href="{{asset('b/assets/libs/@mdi/font/css/materialdesignicons.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('b/assets/libs/@iconscout/unicons/css/line.css')}}" type="text/css" rel="stylesheet">
        <!-- Style Css-->
        <link href="{{asset('b/assets/css/style.min.css')}}" id="color-opt" class="theme-opt" rel="stylesheet" type="text/css">
    </head>

    <body>
        <!-- Loader -->
        <!-- <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
            </div>
        </div> -->
        <!-- Loader -->



        <!-- Navbar Start -->
        <header id="topnav" class="defaultscroll sticky">
            <div class="container">
                <!-- Logo container-->
                <a class="logo" href="{{route('main')}}">
                    <span class="logo-light-mode">
                        <img src="{{asset('logo.png')}}" class="l-dark" height="24" alt="">
                        <img src="{{asset('logo.png')}}" class="l-light" height="24" alt="">
                    </span>
                    <img src="{{asset('logo.png')}}" height="24" class="logo-dark-mode" alt="">
                </a>

                <!-- End Logo container-->
                <div class="menu-extras">
                    <div class="menu-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </div>
                </div>

                <!--Login button Start-->
                <ul class="buy-button list-inline mb-0">
                    <li class="list-inline-item mb-0">
                        <a href="javascript:void(0)" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            <div class="login-btn-primary"><span class="btn btn-icon btn-pills btn-soft-primary"><i data-feather="settings" class="fea icon-sm"></i></span></div>
                            <div class="login-btn-light"><span class="btn btn-icon btn-pills btn-light"><i data-feather="settings" class="fea icon-sm"></i></span></div>
                        </a>
                    </li>

                    <li class="list-inline-item ps-1 mb-0">
                        <a href="https://1.envato.market/landrick" target="_blank">
                            <div class="login-btn-primary"><span class="btn btn-icon btn-pills btn-primary"><i data-feather="shopping-cart" class="fea icon-sm"></i></span></div>
                            <div class="login-btn-light"><span class="btn btn-icon btn-pills btn-light"><i data-feather="shopping-cart" class="fea icon-sm"></i></span></div>
                        </a>
                    </li>
                </ul>
                <!--Login button End-->

                <div id="navigation">
                    <!-- Navigation Menu-->
                    <ul class="navigation-menu nav-light">
                        <li><a href="{{route('main')}}" class="sub-menu-item">Inicio</a></li>

                    </ul><!--end navigation menu-->
                </div><!--end navigation-->
            </div><!--end container-->
        </header><!--end header-->
        <!-- Navbar End -->

        <!-- Hero Start -->
        <section class="bg-half-170 pb-0 bg-primary d-table w-100" style="background: url('{{asset('b/assets/images/bg2.png')}}') center center;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-6">
                        <div class="title-heading mb-md-5 pb-md-5">
                            <h5 class="text-white-50">La digitalización llegó</h5>
                            <h4 class="heading text-white mb-3 title-dark"> Adquiere tu firma electrónica <br> Ahora! </h4>
                            <p class="para-desc text-white-50">Ya sea si tienes que firmar un documento PDF o una factura electrónica nosotros te ayudamos.</p>
                            <div class="mt-4 pt-2">
                                <a href="javascript:void(0)" class="btn btn-light">Obtener mi firma</a>
                            </div>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-5 col-md-6 mt-5 mt-sm-0">
                        <img src="{{asset('b/assets/images/hero1.png')}}" class="img-fluid" alt="">
                    </div>
                </div><!--end row-->
            </div> <!--end container-->
        </section><!--end section-->
        <!-- Hero End -->

        <!-- Partners start -->
        <section class="py-4 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-2 col-md-2 col-6 text-center py-4">
                        <img src="assets/images/client/amazon.svg" class="avatar avatar-ex-sm" alt="">
                    </div><!--end col-->

                    <div class="col-lg-2 col-md-2 col-6 text-center py-4">
                        <img src="assets/images/client/google.svg" class="avatar avatar-ex-sm" alt="">
                    </div><!--end col-->

                    <div class="col-lg-2 col-md-2 col-6 text-center py-4">
                        <img src="assets/images/client/lenovo.svg" class="avatar avatar-ex-sm" alt="">
                    </div><!--end col-->

                    <div class="col-lg-2 col-md-2 col-6 text-center py-4">
                        <img src="assets/images/client/paypal.svg" class="avatar avatar-ex-sm" alt="">
                    </div><!--end col-->

                    <div class="col-lg-2 col-md-2 col-6 text-center py-4">
                        <img src="assets/images/client/shopify.svg" class="avatar avatar-ex-sm" alt="">
                    </div><!--end col-->

                    <div class="col-lg-2 col-md-2 col-6 text-center py-4">
                        <img src="assets/images/client/spotify.svg" class="avatar avatar-ex-sm" alt="">
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- Partners End -->

        <section class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <div class="section-title mb-4 pb-2">
                            <h4 class="title mb-4">What we do ?</h4>
                            <p class="text-muted para-desc mb-0 mx-auto">Start working with <span class="text-primary fw-bold">Landrick</span> that can provide everything you need to generate awareness, drive traffic, connect.</p>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">
                    <div class="col-lg-3 col-md-4 mt-4 pt-2">
                        <div class="card features feature-primary feature-full-bg rounded p-4 bg-light text-center position-relative overflow-hidden border-0">
                            <span class="h1 icon-color">
                                <i class="uil uil-chart-line"></i>
                            </span>
                            <div class="card-body p-0 content">
                                <h5>Hign Performance</h5>
                                <p class="para text-muted mb-0">It is a long established fact that a reader.</p>
                            </div>
                            <span class="big-icon text-center">
                                <i class="uil uil-chart-line"></i>
                            </span>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-3 col-md-4 mt-4 pt-2">
                        <div class="card features feature-primary feature-full-bg rounded p-4 bg-light text-center position-relative overflow-hidden border-0">
                            <span class="h1 icon-color">
                                <i class="uil uil-crosshairs"></i>
                            </span>
                            <div class="card-body p-0 content">
                                <h5>Best Securities</h5>
                                <p class="para text-muted mb-0">It is a long established fact that a reader.</p>
                            </div>
                            <span class="big-icon text-center">
                                <i class="uil uil-crosshairs"></i>
                            </span>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-3 col-md-4 mt-4 pt-2">
                        <div class="card features feature-primary feature-full-bg rounded p-4 bg-light text-center position-relative overflow-hidden border-0">
                            <span class="h1 icon-color">
                                <i class="uil uil-airplay"></i>
                            </span>
                            <div class="card-body p-0 content">
                                <h5>Trusted Service</h5>
                                <p class="para text-muted mb-0">It is a long established fact that a reader.</p>
                            </div>
                            <span class="big-icon text-center">
                                <i class="uil uil-airplay"></i>
                            </span>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-3 col-md-4 mt-4 pt-2">
                        <div class="card features feature-primary feature-full-bg rounded p-4 bg-light text-center position-relative overflow-hidden border-0">
                            <span class="h1 icon-color">
                                <i class="uil uil-rocket"></i>
                            </span>
                            <div class="card-body p-0 content">
                                <h5>Info Technology</h5>
                                <p class="para text-muted mb-0">It is a long established fact that a reader.</p>
                            </div>
                            <span class="big-icon text-center">
                                <i class="uil uil-rocket"></i>
                            </span>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-3 col-md-4 mt-4 pt-2">
                        <div class="card features feature-primary feature-full-bg rounded p-4 bg-light text-center position-relative overflow-hidden border-0">
                            <span class="h1 icon-color">
                                <i class="uil uil-clock"></i>
                            </span>
                            <div class="card-body p-0 content">
                                <h5>24/7 Support</h5>
                                <p class="para text-muted mb-0">It is a long established fact that a reader.</p>
                            </div>
                            <span class="big-icon text-center">
                                <i class="uil uil-clock"></i>
                            </span>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-3 col-md-4 mt-4 pt-2">
                        <div class="card features feature-primary feature-full-bg rounded p-4 bg-light text-center position-relative overflow-hidden border-0">
                            <span class="h1 icon-color">
                                <i class="uil uil-users-alt"></i>
                            </span>
                            <div class="card-body p-0 content">
                                <h5>IT Management</h5>
                                <p class="para text-muted mb-0">It is a long established fact that a reader.</p>
                            </div>
                            <span class="big-icon text-center">
                                <i class="uil uil-users-alt"></i>
                            </span>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-3 col-md-4 mt-4 pt-2">
                        <div class="card features feature-primary feature-full-bg rounded p-4 bg-light text-center position-relative overflow-hidden border-0">
                            <span class="h1 icon-color">
                                <i class="uil uil-file-alt"></i>
                            </span>
                            <div class="card-body p-0 content">
                                <h5>Certified Company</h5>
                                <p class="para text-muted mb-0">It is a long established fact that a reader.</p>
                            </div>
                            <span class="big-icon text-center">
                                <i class="uil uil-file-alt"></i>
                            </span>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-3 col-md-4 mt-4 pt-2">
                        <div class="card features feature-primary feature-full-bg rounded p-4 bg-light text-center position-relative overflow-hidden border-0">
                            <span class="h1 icon-color">
                                <i class="uil uil-search"></i>
                            </span>
                            <div class="card-body p-0 content">
                                <h5>Data Analytics</h5>
                                <p class="para text-muted mb-0">It is a long established fact that a reader.</p>
                            </div>
                            <span class="big-icon text-center">
                                <i class="uil uil-search"></i>
                            </span>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-12 text-center col-md-4 mt-4 pt-2">
                        <a href="javascript:void(0)" class="btn btn-primary">See more <i data-feather="arrow-right" class="fea icon-sm"></i></a>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->

            <!-- About Start -->
            <div class="container mt-100 mt-60">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-6 mt-4 mt-lg-0 pt-2 pt-lg-0">
                                <div class="card work-container work-primary work-modern overflow-hidden rounded border-0 shadow-md">
                                    <div class="card-body p-0">
                                        <img src="assets/images/course/online/ab01.jpg" class="img-fluid" alt="work-image">
                                        <div class="overlay-work"></div>
                                        <div class="content">
                                            <a href="javascript:void(0)" class="title text-white d-block fw-bold">Web Development</a>
                                            <small class="text-white-50">IT & Software</small>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end col-->

                            <div class="col-lg-6 col-6">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 mt-4 mt-lg-0 pt-2 pt-lg-0">
                                        <div class="card work-container work-primary work-modern overflow-hidden rounded border-0 shadow-md">
                                            <div class="card-body p-0">
                                                <img src="assets/images/course/online/ab02.jpg" class="img-fluid" alt="work-image">
                                                <div class="overlay-work"></div>
                                                <div class="content">
                                                    <a href="javascript:void(0)" class="title text-white d-block fw-bold">Michanical Engineer</a>
                                                    <small class="text-white-50">Engineering</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-lg-12 col-md-12 mt-4 pt-2">
                                        <div class="card work-container work-primary work-modern overflow-hidden rounded border-0 shadow-md">
                                            <div class="card-body p-0">
                                                <img src="assets/images/course/online/ab03.jpg" class="img-fluid" alt="work-image">
                                                <div class="overlay-work"></div>
                                                <div class="content">
                                                    <a href="javascript:void(0)" class="title text-white d-block fw-bold">Chartered Accountant</a>
                                                    <small class="text-white-50">C.A.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end col-->

                    <div class="col-lg-6 col-md-6 mt-4 mt-lg-0 pt-2 pt-lg-0">
                        <div class="ms-lg-4">
                            <div class="section-title mb-4 pb-2">
                                <h4 class="title mb-4">About Our Story</h4>
                                <p class="text-muted para-desc">Start working with <span class="text-primary fw-bold">Landrick</span> that can provide everything you need to generate awareness, drive traffic, connect.</p>
                                <p class="text-muted para-desc mb-0">The most well-known dummy text is the 'Lorem Ipsum', which is said to have originated in the 16th century. Lorem Ipsum is composed in a pseudo-Latin language which more or less corresponds to 'proper' Latin. It contains a series of real Latin words.</p>
                            </div>

                            <ul class="list-unstyled text-muted">
                                <li class="mb-0"><span class="text-primary h4 me-2"><i class="uil uil-check-circle align-middle"></i></span>Fully Responsive</li>
                                <li class="mb-0"><span class="text-primary h4 me-2"><i class="uil uil-check-circle align-middle"></i></span>Multiple Layouts</li>
                                <li class="mb-0"><span class="text-primary h4 me-2"><i class="uil uil-check-circle align-middle"></i></span>Suits Your Style</li>
                            </ul>

                            <div class="mt-4 pt-2">
                                <a href="https://1.envato.market/landrick" target="_blank" class="btn btn-primary m-1">Read More <i class="uil uil-angle-right-b align-middle"></i></a>
                                <a href="#!" data-type="youtube" data-id="yba7hPeTSjk" class="btn btn-icon btn-pills btn-primary m-1 lightbox"><i data-feather="video" class="icons"></i></a><span class="fw-bold text-uppercase small align-middle ms-1">Watch Now</span>
                            </div>
                        </div>
                    </div>
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->

        <!-- Start -->
        <section class="section pt-0">
            <div class="container">
                <div class="p-4 rounded shadow bg-primary bg-gradient position-relative" style="z-index: 1;">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="progress-box">
                                <h6 class="title text-white">Web Designing</h6>
                                <div class="progress title-bg-dark" style="height: 10px; padding: 3px">
                                    <div class="progress-bar position-relative bg-black" style="width:84%;">
                                        <div class="progress-value d-block text-white-50 h6">84%</div>
                                    </div>
                                </div>
                            </div><!--end process box-->
                            <div class="progress-box mt-4">
                                <h6 class="title text-white">Web Development</h6>
                                <div class="progress title-bg-dark" style="height: 10px; padding: 3px">
                                    <div class="progress-bar position-relative bg-black" style="width:75%;">
                                        <div class="progress-value d-block text-white-50 h6">75%</div>
                                    </div>
                                </div>
                            </div><!--end process box-->
                            <div class="progress-box mt-4">
                                <h6 class="title text-white">Game Development</h6>
                                <div class="progress title-bg-dark" style="height: 10px; padding: 3px">
                                    <div class="progress-bar position-relative bg-black" style="width:79%;">
                                        <div class="progress-value d-block text-white-50 h6">79%</div>
                                    </div>
                                </div>
                            </div><!--end process box-->
                        </div><!--end col-->

                        <div class="col-md-6 col-12">
                            <div class="progress-box mt-4 mt-sm-0">
                                <h6 class="title text-white">App Development</h6>
                                <div class="progress title-bg-dark" style="height: 10px; padding: 3px">
                                    <div class="progress-bar position-relative bg-black" style="width:84%;">
                                        <div class="progress-value d-block text-white-50 h6">84%</div>
                                    </div>
                                </div>
                            </div><!--end process box-->
                            <div class="progress-box mt-4">
                                <h6 class="title text-white">Digital Marketing</h6>
                                <div class="progress title-bg-dark" style="height: 10px; padding: 3px">
                                    <div class="progress-bar position-relative bg-black" style="width:75%;">
                                        <div class="progress-value d-block text-white-50 h6">75%</div>
                                    </div>
                                </div>
                            </div><!--end process box-->
                            <div class="progress-box mt-4">
                                <h6 class="title text-white">Full stack Development</h6>
                                <div class="progress title-bg-dark" style="height: 10px; padding: 3px">
                                    <div class="progress-bar position-relative bg-black" style="width:79%;">
                                        <div class="progress-value d-block text-white-50 h6">79%</div>
                                    </div>
                                </div>
                            </div><!--end process box-->
                        </div><!--end col-->
                    </div><!--end row -->
                </div>

                <div class="row mt-4 pt-2 position-relative" id="counter" style="z-index: 1;">
                    <div class="col-md-3 col-6 mt-4 pt-2">
                        <div class="counter-box text-center">
                            <img src="assets/images/illustrator/Asset190.svg" class="avatar avatar-small" alt="">
                            <h2 class="mb-0 mt-4"><span class="counter-value" data-target="97">3</span>%</h2>
                            <h6 class="counter-head text-muted">Happy Client</h6>
                        </div><!--end counter box-->
                    </div>

                    <div class="col-md-3 col-6 mt-4 pt-2">
                        <div class="counter-box text-center">
                            <img src="assets/images/illustrator/Asset189.svg" class="avatar avatar-small" alt="">
                            <h2 class="mb-0 mt-4"><span class="counter-value" data-target="15">1</span>+</h2>
                            <h6 class="counter-head text-muted">Awards</h6>
                        </div><!--end counter box-->
                    </div>

                    <div class="col-md-3 col-6 mt-4 pt-2">
                        <div class="counter-box text-center">
                            <img src="assets/images/illustrator/Asset192.svg" class="avatar avatar-small" alt="">
                            <h2 class="mb-0 mt-4"><span class="counter-value" data-target="2">0</span>K</h2>
                            <h6 class="counter-head text-muted">Job Placement</h6>
                        </div><!--end counter box-->
                    </div>

                    <div class="col-md-3 col-6 mt-4 pt-2">
                        <div class="counter-box text-center">
                            <img src="assets/images/illustrator/Asset187.svg" class="avatar avatar-small" alt="">
                            <h2 class="mb-0 mt-4"><span class="counter-value" data-target="98">3</span>%</h2>
                            <h6 class="counter-head text-muted">Project Complete</h6>
                        </div><!--end counter box-->
                    </div>
                </div><!--end row-->
                <div class="feature-posts-placeholder bg-light"></div>
            </div><!--end container-->
        </section><!--end section-->
        <!-- End -->

        <section class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="section-title text-center mb-4 pb-2">
                            <h6 class="text-primary">Work Process</h6>
                            <h4 class="title mb-4">How do we works ?</h4>
                            <p class="text-muted para-desc mx-auto mb-0">Start working with <span class="text-primary fw-bold">Landrick</span> that can provide everything you need to generate awareness, drive traffic, connect.</p>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">
                    <div class="col-md-4 mt-4 pt-2">
                        <div class="card features feature-primary feature-clean work-process bg-transparent process-arrow border-0 text-center">
                            <div class="icons text-center mx-auto">
                                <i class="uil uil-presentation-edit rounded h3 mb-0"></i>
                            </div>

                            <div class="card-body">
                                <h5 class="text-dark">Discussion</h5>
                                <p class="text-muted mb-0">The most well-known dummy text is the 'Lorem Ipsum', which is said to have originated</p>
                            </div>
                        </div>
                    </div><!--end col-->

                    <div class="col-md-4 mt-md-5 pt-md-3 mt-4 pt-2">
                        <div class="card features feature-primary feature-clean work-process bg-transparent process-arrow border-0 text-center">
                            <div class="icons text-center mx-auto">
                                <i class="uil uil-airplay rounded h3 mb-0"></i>
                            </div>

                            <div class="card-body">
                                <h5 class="text-dark">Strategy & Testing</h5>
                                <p class="text-muted mb-0">Generators convallis odio, vel pharetra quam malesuada vel. Nam porttitor malesuada.</p>
                            </div>
                        </div>
                    </div><!--end col-->

                    <div class="col-md-4 mt-md-5 pt-md-5 mt-4 pt-2">
                        <div class="card features feature-primary feature-clean work-process bg-transparent d-none-arrow border-0 text-center">
                            <div class="icons text-center mx-auto">
                                <i class="uil uil-image-check rounded h3 mb-0"></i>
                            </div>

                            <div class="card-body">
                                <h5 class="text-dark">Reporting</h5>
                                <p class="text-muted mb-0">Internet Proin tempus odio, vel pharetra quam malesuada vel. Nam porttitor malesuada.</p>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->

            <div class="container mt-100 mt-60">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="section-title text-center mb-4 pb-2">
                            <h4 class="title mb-4">Our Mind Power</h4>
                            <p class="text-muted para-desc mx-auto mb-0">Start working with <span class="text-primary fw-bold">Landrick</span> that can provide everything you need to generate awareness, drive traffic, connect.</p>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">
                    <div class="col-lg-3 col-md-6 mt-4 pt-2">
                        <div class="card team team-primary text-center border-0">
                            <div class="position-relative">
                                <img src="assets/images/client/01.jpg" class="img-fluid avatar avatar-ex-large rounded-circle shadow" alt="">
                                <ul class="list-unstyled mb-0 team-icon">
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="facebook" class="icons"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="instagram" class="icons"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="twitter" class="icons"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="linkedin" class="icons"></i></a></li>
                                </ul><!--end icon-->
                            </div>
                            <div class="card-body py-3 px-0 content">
                                <h5 class="mb-0"><a href="javascript:void(0)" class="name text-dark">Ronny Jofra</a></h5>
                                <small class="designation text-muted">C.E.O</small>
                            </div>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-3 col-md-6 mt-4 pt-2">
                        <div class="card team team-primary text-center border-0">
                            <div class="position-relative">
                                <img src="assets/images/client/04.jpg" class="img-fluid avatar avatar-ex-large rounded-circle shadow" alt="">
                                <ul class="list-unstyled mb-0 team-icon">
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="facebook" class="icons"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="instagram" class="icons"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="twitter" class="icons"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="linkedin" class="icons"></i></a></li>
                                </ul><!--end icon-->
                            </div>
                            <div class="card-body py-3 px-0 content">
                                <h5 class="mb-0"><a href="javascript:void(0)" class="name text-dark">Micheal Carlo</a></h5>
                                <small class="designation text-muted">Director</small>
                            </div>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-3 col-md-6 mt-4 pt-2">
                        <div class="card team team-primary text-center border-0">
                            <div class="position-relative">
                                <img src="assets/images/client/02.jpg" class="img-fluid avatar avatar-ex-large rounded-circle shadow" alt="">
                                <ul class="list-unstyled mb-0 team-icon">
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="facebook" class="icons"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="instagram" class="icons"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="twitter" class="icons"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="linkedin" class="icons"></i></a></li>
                                </ul><!--end icon-->
                            </div>
                            <div class="card-body py-3 px-0 content">
                                <h5 class="mb-0"><a href="javascript:void(0)" class="name text-dark">Aliana Rosy</a></h5>
                                <small class="designation text-muted">Manager</small>
                            </div>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-3 col-md-6 mt-4 pt-2">
                        <div class="card team team-primary text-center border-0">
                            <div class="position-relative">
                                <img src="assets/images/client/03.jpg" class="img-fluid avatar avatar-ex-large rounded-circle shadow" alt="">
                                <ul class="list-unstyled mb-0 team-icon">
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="facebook" class="icons"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="instagram" class="icons"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="twitter" class="icons"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="linkedin" class="icons"></i></a></li>
                                </ul><!--end icon-->
                            </div>
                            <div class="card-body py-3 px-0 content">
                                <h5 class="mb-0"><a href="javascript:void(0)" class="name text-dark">Sofia Razaq</a></h5>
                                <small class="designation text-muted">Developer</small>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->

        <section class="section bg-light">
            <div class="container">
                <div class="row align-items-center mb-4 pb-2">
                    <div class="col-lg-6">
                        <div class="section-title text-center text-lg-start">
                            <h6 class="text-primary">Blog</h6>
                            <h4 class="title mb-4 mb-lg-0">Reads Our Latest <br> News & Blog</h4>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-6">
                        <div class="section-title text-center text-lg-start">
                            <p class="text-muted mb-0 mx-auto para-desc">Start working with <span class="text-primary fw-bold">Landrick</span> that can provide everything you need to generate awareness, drive traffic, connect.</p>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">
                    <div class="col-lg-4 col-md-6 mt-4 pt-2">
                        <div class="card blog blog-primary rounded border-0 shadow">
                            <div class="position-relative">
                                <img src="assets/images/blog/01.jpg" class="card-img-top rounded-top" alt="...">
                                <div class="overlay rounded-top"></div>
                            </div>
                            <div class="card-body content">
                                <h5><a href="javascript:void(0)" class="card-title title text-dark">Design your apps in your own way</a></h5>
                                <div class="post-meta d-flex justify-content-between mt-3">
                                    <ul class="list-unstyled mb-0">
                                        <li class="list-inline-item me-2 mb-0"><a href="javascript:void(0)" class="text-muted like"><i class="uil uil-heart me-1"></i>33</a></li>
                                        <li class="list-inline-item"><a href="javascript:void(0)" class="text-muted comments"><i class="uil uil-comment me-1"></i>08</a></li>
                                    </ul>
                                    <a href="blog-detail.html" class="text-muted readmore">Read More <i class="uil uil-angle-right-b align-middle"></i></a>
                                </div>
                            </div>
                            <div class="author">
                                <small class="user d-block"><i class="uil uil-user"></i> Calvin Carlo</small>
                                <small class="date"><i class="uil uil-calendar-alt"></i> 25th June 2021</small>
                            </div>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-4 col-md-6 mt-4 pt-2">
                        <div class="card blog blog-primary rounded border-0 shadow">
                            <div class="position-relative">
                                <img src="assets/images/blog/02.jpg" class="card-img-top rounded-top" alt="...">
                                <div class="overlay rounded-top"></div>
                            </div>
                            <div class="card-body content">
                                <h5><a href="javascript:void(0)" class="card-title title text-dark">How apps is changing the IT world</a></h5>
                                <div class="post-meta d-flex justify-content-between mt-3">
                                    <ul class="list-unstyled mb-0">
                                        <li class="list-inline-item me-2 mb-0"><a href="javascript:void(0)" class="text-muted like"><i class="uil uil-heart me-1"></i>33</a></li>
                                        <li class="list-inline-item"><a href="javascript:void(0)" class="text-muted comments"><i class="uil uil-comment me-1"></i>08</a></li>
                                    </ul>
                                    <a href="blog-detail.html" class="text-muted readmore">Read More <i class="uil uil-angle-right-b align-middle"></i></a>
                                </div>
                            </div>
                            <div class="author">
                                <small class="user d-block"><i class="uil uil-user"></i> Calvin Carlo</small>
                                <small class="date"><i class="uil uil-calendar-alt"></i> 25th June 2021</small>
                            </div>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-4 col-md-6 mt-4 pt-2">
                        <div class="card blog blog-primary rounded border-0 shadow">
                            <div class="position-relative">
                                <img src="assets/images/blog/03.jpg" class="card-img-top rounded-top" alt="...">
                                <div class="overlay rounded-top"></div>
                            </div>
                            <div class="card-body content">
                                <h5><a href="javascript:void(0)" class="card-title title text-dark">Smartest Applications for Business</a></h5>
                                <div class="post-meta d-flex justify-content-between mt-3">
                                    <ul class="list-unstyled mb-0">
                                        <li class="list-inline-item me-2 mb-0"><a href="javascript:void(0)" class="text-muted like"><i class="uil uil-heart me-1"></i>33</a></li>
                                        <li class="list-inline-item"><a href="javascript:void(0)" class="text-muted comments"><i class="uil uil-comment me-1"></i>08</a></li>
                                    </ul>
                                    <a href="blog-detail.html" class="text-muted readmore">Read More <i class="uil uil-angle-right-b align-middle"></i></a>
                                </div>
                            </div>
                            <div class="author">
                                <small class="user d-block"><i class="uil uil-user"></i> Calvin Carlo</small>
                                <small class="date"><i class="uil uil-calendar-alt"></i> 25th June 2021</small>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->


        <!-- Footer Start -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="footer-py-60">
                            <div class="row">
                                <div class="col-lg-4 col-12 mb-0 mb-md-4 pb-0 pb-md-2">
                                    <a href="#" class="logo-footer">
                                        <img src="{{asset('b/assets/images/logo-light.png')}}" height="24" alt="">
                                    </a>
                                    <p class="mt-4">Start working with Landrick that can provide everything you need to generate awareness, drive traffic, connect.</p>
                                    <ul class="list-unstyled social-icon foot-social-icon mb-0 mt-4">
                                        <li class="list-inline-item mb-0"><a href="https://1.envato.market/landrick" target="_blank" class="rounded"><i class="uil uil-shopping-cart align-middle" title="Buy Now"></i></a></li>
                                        <li class="list-inline-item mb-0"><a href="https://dribbble.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-dribbble align-middle" title="dribbble"></i></a></li>
                                        <li class="list-inline-item mb-0"><a href="https://www.behance.net/shreethemes" target="_blank" class="rounded"><i class="uil uil-behance align-middle" title="behance"></i></a></li>
                                        <li class="list-inline-item mb-0"><a href="https://www.facebook.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-facebook-f align-middle" title="facebook"></i></a></li>
                                        <li class="list-inline-item mb-0"><a href="https://www.instagram.com/shreethemes/" target="_blank" class="rounded"><i class="uil uil-instagram align-middle" title="instagram"></i></a></li>
                                        <li class="list-inline-item mb-0"><a href="https://twitter.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-twitter align-middle" title="twitter"></i></a></li>
                                        <li class="list-inline-item mb-0"><a href="mailto:support@shreethemes.in" class="rounded"><i class="uil uil-envelope align-middle" title="email"></i></a></li>
                                    </ul><!--end icon-->
                                </div><!--end col-->

                                <div class="col-lg-2 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                                    <h5 class="footer-head">Company</h5>
                                    <ul class="list-unstyled footer-list mt-4">
                                        <li><a href="javascript:void(0)" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> About us</a></li>
                                        <li><a href="javascript:void(0)" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Services</a></li>
                                        <li><a href="javascript:void(0)" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Team</a></li>
                                        <li><a href="javascript:void(0)" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Pricing</a></li>
                                        <li><a href="javascript:void(0)" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Project</a></li>
                                        <li><a href="javascript:void(0)" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Careers</a></li>
                                        <li><a href="javascript:void(0)" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Blog</a></li>
                                        <li><a href="javascript:void(0)" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Login</a></li>
                                    </ul>
                                </div><!--end col-->

                                <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                                    <h5 class="footer-head">Usefull Links</h5>
                                    <ul class="list-unstyled footer-list mt-4">
                                        <li><a href="javascript:void(0)" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Terms of Services</a></li>
                                        <li><a href="javascript:void(0)" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Privacy Policy</a></li>
                                        <li><a href="javascript:void(0)" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Documentation</a></li>
                                        <li><a href="javascript:void(0)" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Changelog</a></li>
                                        <li><a href="javascript:void(0)" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Components</a></li>
                                    </ul>
                                </div><!--end col-->

                                <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                                    <h5 class="footer-head">Newsletter</h5>
                                    <p class="mt-4">Sign up and receive the latest tips via email.</p>
                                    <form>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="foot-subscribe mb-3">
                                                    <label class="form-label">Write your email <span class="text-danger">*</span></label>
                                                    <div class="form-icon position-relative">
                                                        <i data-feather="mail" class="fea icon-sm icons"></i>
                                                        <input type="email" name="email" id="emailsubscribe" class="form-control ps-5 rounded" placeholder="Your email : " required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="d-grid">
                                                    <input type="submit" id="submitsubscribe" name="send" class="btn btn-soft-primary" value="Subscribe">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->

            <div class="footer-py-30 footer-bar">
                <div class="container text-center">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="text-sm-start">
                                <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Landrick. Design with <i class="mdi mdi-heart text-danger"></i> by <a href="https://shreethemes.in/" target="_blank" class="text-reset">Shreethemes</a>.</p>
                            </div>
                        </div><!--end col-->

                        <div class="col-sm-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                            <ul class="list-unstyled text-sm-end mb-0">
                                <li class="list-inline-item"><a href="javascript:void(0)"><img src="{{asset("b/assets/images/payments/american-ex.png")}}" class="avatar avatar-ex-sm" title="American Express" alt=""></a></li>
                                <li class="list-inline-item"><a href="javascript:void(0)"><img src="{{asset("b/assets/images/payments/discover.png")}}" class="avatar avatar-ex-sm" title="Discover" alt=""></a></li>
                                <li class="list-inline-item"><a href="javascript:void(0)"><img src="{{asset("b/assets/images/payments/master-card.png")}}" class="avatar avatar-ex-sm" title="Master Card" alt=""></a></li>
                                <li class="list-inline-item"><a href="javascript:void(0)"><img src="{{asset("b/assets/images/payments/paypal.png")}}" class="avatar avatar-ex-sm" title="Paypal" alt=""></a></li>
                                <li class="list-inline-item"><a href="javascript:void(0)"><img src="{{asset("b/assets/images/payments/visa.png")}}" class="avatar avatar-ex-sm" title="Visa" alt=""></a></li>
                            </ul>
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end container-->
            </div>
        </footer><!--end footer-->
        <!-- Footer End -->





        <!-- Offcanvas Start -->
        <div class="offcanvas offcanvas-end shadow border-0" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header p-4 border-bottom">
                <h5 id="offcanvasRightLabel" class="mb-0">
                    <img src="{{asset('logo.png')}}" height="24" class="light-version" alt="">
                    <img src="{{asset('logo.png')}}" height="24" class="dark-version" alt="">
                </h5>
                <button type="button" class="btn-close d-flex align-items-center text-dark" data-bs-dismiss="offcanvas" aria-label="Close"><i class="uil uil-times fs-4"></i></button>
            </div>
            <div class="offcanvas-body p-4">
                <div class="row">
                    <div class="col-12">
                        <img src="{{asset('b/assets/images/contact.svg')}}"" class="img-fluid d-block mx-auto" alt="">
                        <div class="card border-0 mt-4" style="z-index: 1">
                            <div class="card-body p-0">
                                <h4 class="card-title text-center">Login</h4>
                                <form class="login-form mt-4">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Your Email <span class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="user" class="fea icon-sm icons"></i>
                                                    <input type="email" class="form-control ps-5" placeholder="Email" name="email" required="">
                                                </div>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="key" class="fea icon-sm icons"></i>
                                                    <input type="password" class="form-control ps-5" placeholder="Password" required="">
                                                </div>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-between">
                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                        <label class="form-check-label" for="flexCheckDefault">Remember me</label>
                                                    </div>
                                                </div>
                                                <p class="forgot-pass mb-0"><a href="auth-cover-re-password.html" class="text-dark fw-bold">Forgot password ?</a></p>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-12 mb-0">
                                            <div class="d-grid">
                                                <button class="btn btn-primary">Sign in</button>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-12 text-center">
                                            <p class="mb-0 mt-3"><small class="text-dark me-2">Don't have an account ?</small> <a href="auth-cover-signup.html" class="text-dark fw-bold">Sign Up</a></p>
                                        </div><!--end col-->
                                    </div><!--end row-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="offcanvas-footer p-4 border-top text-center">
                <ul class="list-unstyled social-icon social mb-0">
                    <li class="list-inline-item mb-0"><a href="https://1.envato.market/landrick" target="_blank" class="rounded"><i class="uil uil-shopping-cart align-middle" title="Buy Now"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://dribbble.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-dribbble align-middle" title="dribbble"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://www.behance.net/shreethemes" target="_blank" class="rounded"><i class="uil uil-behance align-middle" title="behance"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://www.facebook.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-facebook-f align-middle" title="facebook"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://www.instagram.com/shreethemes/" target="_blank" class="rounded"><i class="uil uil-instagram align-middle" title="instagram"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://twitter.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-twitter align-middle" title="twitter"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="mailto:support@shreethemes.in" class="rounded"><i class="uil uil-envelope align-middle" title="email"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://shreethemes.in" target="_blank" class="rounded"><i class="uil uil-globe align-middle" title="website"></i></a></li>
                </ul><!--end icon-->
            </div>
        </div>
        <!-- Offcanvas End -->
        <!-- Switcher Start -->
        <a href="javascript:void(0)" class="card switcher-btn shadow-md text-primary z-index-1 d-md-inline-flex d-none" data-bs-toggle="offcanvas" data-bs-target="#switcher-sidebar">
            <i class="mdi mdi-cog mdi-24px mdi-spin align-middle"></i>
        </a>

        <div class="offcanvas offcanvas-start shadow border-0" tabindex="-1" id="switcher-sidebar" aria-labelledby="offcanvasLeftLabel">
            <div class="offcanvas-header p-4 border-bottom">
                <h5 id="offcanvasLeftLabel" class="mb-0">
                    <img src="assets/images/logo-dark.png" height="24" class="light-version" alt="">
                    <img src="assets/images/logo-light.png" height="24" class="dark-version" alt="">
                </h5>
                <button type="button" class="btn-close d-flex align-items-center text-dark" data-bs-dismiss="offcanvas" aria-label="Close"><i class="uil uil-times fs-4"></i></button>
            </div>
            <div class="offcanvas-body p-4 pb-0">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <h6 class="fw-bold">Select your color</h6>
                            <ul class="pattern mb-0 mt-3">
                                <li>
                                    <a class="color-list rounded color1" href="javascript: void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Primary" onclick="setColorPrimary()"></a>
                                </li>
                                <li>
                                    <a class="color-list rounded color2" href="javascript: void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Green" onclick="setColor('green')"></a>
                                </li>
                                <li>
                                    <a class="color-list rounded color3" href="javascript: void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Yellow" onclick="setColor('yellow')"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="text-center mt-4 pt-4 border-top">
                            <h6 class="fw-bold">Theme Options</h6>

                            <ul class="text-center style-switcher list-unstyled mt-4">
                                <li class="d-grid"><a href="javascript:void(0)" class="rtl-version t-rtl-light" onclick="setTheme('style-rtl')"><img src="assets/images/demos/rtl.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">RTL Version</span></a></li>
                                    <li class="d-grid"><a href="javascript:void(0)" class="ltr-version t-ltr-light" onclick="setTheme('style')"><img src="assets/images/demos/ltr.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">LTR Version</span></a></li>
                                    <li class="d-grid"><a href="javascript:void(0)" class="dark-rtl-version t-rtl-dark" onclick="setTheme('style-dark-rtl')"><img src="assets/images/demos/dark-rtl.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">RTL Version</span></a></li>
                                    <li class="d-grid"><a href="javascript:void(0)" class="dark-ltr-version t-ltr-dark" onclick="setTheme('style-dark')"><img src="assets/images/demos/dark.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">LTR Version</span></a></li>
                                    <li class="d-grid"><a href="javascript:void(0)" class="dark-version t-dark mt-4" onclick="setTheme('style-dark')"><img src="assets/images/demos/dark.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">Dark Version</span></a></li>
                                    <li class="d-grid"><a href="javascript:void(0)" class="light-version t-light mt-4" onclick="setTheme('style')"><img src="assets/images/demos/ltr.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">Light Version</span></a></li>
                                <li class="d-grid"><a href="../../dashboard/dist/index.html" target="_blank" class="mt-4"><img src="assets/images/demos/admin.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">Admin Dashboard</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="offcanvas-footer p-4 border-top text-center">
                <ul class="list-unstyled social-icon social mb-0">
                    <li class="list-inline-item mb-0"><a href="https://1.envato.market/landrick" target="_blank" class="rounded"><i class="uil uil-shopping-cart align-middle" title="Buy Now"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://dribbble.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-dribbble align-middle" title="dribbble"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://www.behance.net/shreethemes" target="_blank" class="rounded"><i class="uil uil-behance align-middle" title="behance"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://www.facebook.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-facebook-f align-middle" title="facebook"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://www.instagram.com/shreethemes/" target="_blank" class="rounded"><i class="uil uil-instagram align-middle" title="instagram"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://twitter.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-twitter align-middle" title="twitter"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="mailto:support@shreethemes.in" class="rounded"><i class="uil uil-envelope align-middle" title="email"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://shreethemes.in" target="_blank" class="rounded"><i class="uil uil-globe align-middle" title="website"></i></a></li>
                </ul>
            </div>
        </div>
        <!-- Switcher End -->

        <!-- Back to top -->
        <a href="#" onclick="topFunction()" id="back-to-top" class="back-to-top fs-5"><i data-feather="arrow-up" class="fea icon-sm icons align-middle"></i></a>
        <!-- Back to top -->

        <!-- Javascript -->
        <!-- JAVASCRIPT -->
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- SLIDER -->
        <script src="assets/libs/tiny-slider/min/tiny-slider.js"></script>
        <!-- Lightbox -->
        <script src="assets/libs/tobii/js/tobii.min.js"></script>
        <!-- Main Js -->
        <script src="assets/libs/feather-icons/feather.min.js"></script>
        <script src="assets/js/plugins.init.js"></script><!--Note: All init js like tiny slider, counter, countdown, maintenance, lightbox, gallery, swiper slider, aos animation etc.-->
        <script src="assets/js/app.js"></script><!--Note: All important javascript like page loader, menu, sticky menu, menu-toggler, one page menu etc. -->
    </body>
</html>
