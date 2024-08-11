<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>News Center</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link rel="icon" href="{{ asset('img/icon.png') }}" type="image/x-icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@100;600;800&display=swap"
        rel="stylesheet" />

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('th/lib/animate/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('th/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('th/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="{{ asset('th/css/style.css') }}" rel="stylesheet" />

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/scroll.css') }}">
</head>

<body>
    {{-- <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End --> --}}

    <!-- Navbar start -->
    <div class="container-fluid sticky-top px-0">
        <div class="container-fluid topbar bg-dark d-none d-lg-block">
            <div class="container px-0">
                <div class="topbar-top d-flex justify-content-between flex-lg-wrap">
                    <div class="top-info flex-grow-0">
                        <span class="rounded-circle btn-sm-square bg-primary me-2">
                            <i class="fas fa-bolt text-white"></i>
                        </span>
                        <div class="pe-2 me-3 border-end border-white d-flex align-items-center">
                            <p class="mb-0 text-white fs-6 fw-normal">Trending</p>
                        </div>
                        @foreach (\App\Models\News::where('status', 'Accept')->withCount('likes')->orderBy('likes_count', 'desc')->take(1)->get() as $news)
                            <div class="overflow-hidden" style="width: 735px">
                                <div id="note" class="ps-2">
                                    <img src="{{ $news->image ? asset('storage/images/' . $news->image) : asset('img/noimg.jpg') }}"
                                        class="img-fluid rounded-circle border border-3 border-primary me-2"
                                        style="width: 30px; height: 30px" alt="" />
                                    <a href="{{ route('news.show', $news->id) }}">
                                        <p class="text-white mb-0 link-hover">
                                            {{ $news->title }}
                                        </p>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid bg-light">
            <div class="container px-0">
                <nav class="navbar navbar-light navbar-expand-xl">
                    <a href="{{ route('index') }}" class="navbar-brand d-block">
                        <img src="{{ asset('img/logo.png') }}" alt="" class="img-fluid"
                            style="max-width: 60px;">
                    </a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-light py-3 justify-content-between" id="navbarCollapse">
                        <div class="scroll-container">
                            <button class="scroll-button left btn btn-outline-primary" id="scrollLeft">
                                <span>&lt;</span>
                            </button>
                            <div class="scroll-content">
                                <div class="navbar-nav mx-lg-4 border-top"
                                    style="white-space: nowrap; max-width: 60vw;">
                                    @foreach (\App\Models\Category::all() as $categories)
                                        <a href="{{ route('news.viewCategory', $categories->id) }}"
                                            class="nav-item nav-link mt-2">{{ $categories->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                            <button class="scroll-button right btn btn-outline-primary" id="scrollRight">
                                <span>&gt;</span>
                            </button>
                        </div>
                        <div class="d-flex flex-nowrap border-top pt-3 pt-xl-0 mx-2">
                            <div class="d-flex">
                                <img src="{{ asset('th/img/weather-icon.png') }}" class="img-fluid w-100 ms-2"
                                    alt="" />
                                <div class="d-flex align-items-center">
                                    <strong class="fs-4 text-secondary">TEMP</strong>
                                    <div class="d-flex flex-column ms-2" style="width: 150px">
                                        <span class="text-body">YOUR CITY</span>
                                        <small>YOUR DATE</small>
                                    </div>
                                </div>
                            </div>
                            <button
                                class="btn-search btn border border-primary btn-md-square rounded-circle bg-white my-auto"
                                data-bs-toggle="modal" data-bs-target="#searchModal">
                                <i class="fas fa-search text-primary"></i>
                            </button>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Search by keyword
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3" placeholder="keywords"
                            aria-describedby="search-icon-1" />
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->

    @yield('content')

    <!-- Footer Start -->
    <div class="container-fluid bg-dark footer py-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-6 col-xl-3">
                    <div class="footer-item-1">
                        <h4 class="mb-4 text-white">Get In Touch</h4>
                        <p class="text-secondary line-h">
                            Address: <span class="text-white">Jakarta</span>
                        </p>
                        <p class="text-secondary line-h">
                            Email: <span class="text-white">theun@gmail.com</span>
                        </p>
                        <p class="text-secondary line-h">
                            Phone: <span class="text-white">+62</span>
                        </p>
                        <div class="d-flex line-h">
                            <a class="btn btn-light me-2 btn-md-square rounded-circle" href="#"><i
                                    class="fab fa-twitter text-dark"></i></a>
                            <a class="btn btn-light me-2 btn-md-square rounded-circle" href="#"><i
                                    class="fab fa-facebook-f text-dark"></i></a>
                            <a class="btn btn-light me-2 btn-md-square rounded-circle" href="#"><i
                                    class="fab fa-youtube text-dark"></i></a>
                            <a class="btn btn-light btn-md-square rounded-circle" href="#"><i
                                    class="fab fa-github text-dark"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3">
                    <div class="footer-item-2">
                        @foreach (\App\Models\News::where('status', 'Accept')->orderBy('created_at', 'desc')->take(1)->get() as $news)
                            <div class="d-flex flex-column mb-4">
                                <h4 class="mb-4 text-white">Recent News</h4>
                                <a href="{{ route('news.viewCategory', $news->category->id) }}">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle border border-2 border-primary overflow-hidden">
                                            <img src="{{ $news->image ? asset('storage/images/' . $news->image) : asset('img/noimg.jpg') }}"
                                                class="img-zoomin img-fluid rounded-circle w-100" alt=""
                                                style="width: 100px; height: 100px; object-fit: cover;" />
                                        </div>
                                        <div class="d-flex flex-column ps-4">
                                            <p class="text-uppercase text-white mb-3">{{ $news->category->name }}</p>
                                            <a href="{{ route('news.show', $news->id) }}" class="h6 text-white">
                                                {{ $news->title }}
                                            </a>
                                            <small class="text-white d-block"><i class="fas fa-calendar-alt me-1"></i>
                                                {{ $news->created_at->translatedFormat('j F Y') }}</small>
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                        @foreach (\App\Models\News::where('status', 'Accept')->orderBy('created_at', 'desc')->skip(1)->take(1)->get() as $news)
                            <div class="d-flex flex-column">
                                <a href="{{ route('news.viewCategory', $news->category->id) }}">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle border border-2 border-primary overflow-hidden">
                                            <img src="{{ $news->image ? asset('storage/images/' . $news->image) : asset('img/noimg.jpg') }}"
                                                class="img-zoomin img-fluid rounded-circle w-100" alt=""
                                                style="width: 100px; height: 100px; object-fit: cover;" />
                                        </div>
                                        <div class="d-flex flex-column ps-4">
                                            <p class="text-uppercase text-white mb-3">{{ $news->category->name }}</p>
                                            <a href="{{ route('news.show', $news->id) }}" class="h6 text-white">
                                                {{ $news->title }}
                                            </a>
                                            <small class="text-white d-block"><i class="fas fa-calendar-alt me-1"></i>
                                                {{ $news->created_at->translatedFormat('j F Y') }}</small>
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3">
                    <div class="d-flex flex-column text-start footer-item-3">
                        <h4 class="mb-4 text-white">Categories</h4>
                        @foreach (\App\Models\Category::orderBy('views', 'desc')->take(6)->get() as $categories)
                            <a class="btn-link text-white"
                                href="{{ route('news.viewCategory', $categories->id) }}"><i
                                    class="fas fa-angle-right text-white me-2"></i> {{ $categories->name }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3">
                    <div class="footer-item-4">
                        <h4 class="mb-4 text-white">Our Gallery</h4>
                        <div class="row g-2">
                            <div class="col-4">
                                <div class="rounded overflow-hidden">
                                    <img src="{{ asset('img/pict1.jpeg') }}"
                                        class="img-zoomin img-fluid rounded w-100" alt="" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="rounded overflow-hidden">
                                    <img src="{{ asset('img/pict2.jpeg') }}"
                                        class="img-zoomin img-fluid rounded w-100" alt="" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="rounded overflow-hidden">
                                    <img src="{{ asset('img/pict3.jpeg') }}"
                                        class="img-zoomin img-fluid rounded w-100" alt="" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="rounded overflow-hidden">
                                    <img src="{{ asset('img/pict4.jpeg') }}"
                                        class="img-zoomin img-fluid rounded w-100" alt="" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="rounded overflow-hidden">
                                    <img src="{{ asset('img/pict5.jpeg') }}"
                                        class="img-zoomin img-fluid rounded w-100" alt="" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="rounded overflow-hidden">
                                    <img src="{{ asset('img/pict6.jpeg') }}"
                                        class="img-zoomin img-fluid rounded w-100" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-light"><a href="#"><i
                                class="fas fa-copyright text-light me-2"></i>Theun</a>, All right reserved.</span>
                </div>
                <div class="col-md-6 my-auto text-center text-md-end text-white">
                    <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                    <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                    <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                    Designed By
                    <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                    Distributed By <a href="https://themewagon.com">ThemeWagon</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-2 border-white rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('th/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('th/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('th/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('th/js/main.js') }}"></script>

    {{-- Custom JS --}}
    <script src="{{ asset('js/shortcut.js') }}"></script>
    <script src="{{ asset('js/scroll.js') }}"></script>
</body>

</html>
