<!-- ==================== Header Start Here ==================== -->
<header class="header__area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="header__main">
                    <div class="header__logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('logo.png') }}" alt="logo"></a>
                    </div>
                    <div class="header__menu">
                        <ul>
                            @auth
                                <li>
                                    <a href="{{ route('my.courses') }}"
                                        class="{{ Route::is('my.courses') ? 'active' : '' }}">
                                        My Courses
                                    </a>
                                </li>
                            @endauth
                            <li>
                                <a href="{{ route('course.index') }}"
                                    class="{{ Route::is('course.index') ? 'active' : '' }}">
                                    Explore Courses
                                </a>
                            </li>
                        </ul>

                    </div>
                    <div class="header__widgets">
                        @auth
                            <div class="header__login">
                                <a href="{{ route('course.create') }}" class="btn btn--warning text--black"><i
                                        class="fa-solid fa-plus"></i>Add Course</a>
                            </div>

                            <a class="btn btn--base" href="{{ route('logout') }}">Logout</a>
                        @else
                            <div class="header__login">
                                <a href="{{ route('login') }}" class="btn btn--warning text--black"><i class="fa-solid fa-right-to-bracket"></i>Login</a>
                            </div>
                        @endauth
                    </div>
                    <span class="menu__open"><i class="fa-solid fa-bars"></i></span>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="offcanvas__area">
    <div class="offcanvas__topbar">
        <a href="{{ route('home') }}"><img src="{{ asset('logo.png') }}" alt="logo"></a>
        <span class="menu__close"><i class="fa-solid fa-xmark"></i></span>
    </div>
    <div class="offcanvas__main">
        <div class="offcanvas__login">
            @auth
                <a href="{{ route('course.create') }}" class="btn btn--warning text--black w-100">
                    <i class="fa-solid fa-plus"></i> Add Course
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn--warning text--black w-100">
                    <i class="fa-solid fa-right-to-bracket"></i> Login
                </a>
            @endauth
        </div>
        <div class="offcanvas__menu">
            <ul>
                <li>
                    <a href="{{ route('home') }}" class="{{ Route::is('home') ? 'active' : '' }}">
                        Home
                    </a>
                </li>

                @auth
                    <li>
                        <a href="{{ route('my.courses') }}"
                            class="{{ Route::is('my.courses') ? 'active' : '' }}">
                            My Courses
                        </a>
                    </li>
                @endauth

                <li>
                    <a href="{{ route('course.index') }}"
                        class="{{ Route::is('course.index') ? 'active' : '' }}">
                        Explore Courses
                    </a>
                </li>
                @auth
                    <li><a href="{{ route('logout') }}">Logout</a></li>
                @endauth
            </ul>
        </div>
    </div>
</div>

<!--==========================  Offcanvas Section End  ==========================-->
