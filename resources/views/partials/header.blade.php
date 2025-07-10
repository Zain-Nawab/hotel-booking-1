<!--================Header Area =================-->
       <header class="header_area">
    <div class="">
        <nav class="navbar navbar-expand-lg navbar-light">
            <!-- Logo -->
            <a class="navbar-brand logo_h" href="{{ route('home.index') }}">
                <img src="{{ asset('image/Logo.png') }}" alt="">
            </a>

            <!-- Toggler icon -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list bg-primary-subtle"></i> <!-- Bootstrap icon for menu -->
            </button>

            <!-- Navigation links -->
            <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                <ul class="nav navbar-nav menu_nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('home.index') }}"><i class="bi bi-house-door-fill mr-1"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog.aboutus') }}"><i class="bi bi-info-circle-fill mr-1"></i>About us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('rooms.index') }}"><i class="bi bi-building mr-1"></i>Accomodation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('user.dashboard') }}"><i class="bi bi-speedometer2 mr-1"></i></i>Dashboard</a>
                    </li>
                    <li class="nav-item submenu dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-journal-text mr-1"></i>Blog
                        </a>
                        <ul class="dropdown-menu">
                            <li class="nav-item"><a class="nav-link" href="{{ route("home.blog") }}">Blog</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('blog.detail') }}">Blog Details</a></li>
                        </ul>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="contact.html"><i class="bi bi-envelope-fill mr-1"></i>Contact</a>
                    </li> --}}

                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('loginForm') }}"><i class="bi bi-box-arrow-in-right mr-1"></i>Login</a>
                    </li>
                    @endguest

                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right mr-1"></i>Logout</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </nav>
    </div>
</header>

        <!--================Header Area =================-->