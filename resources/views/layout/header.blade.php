{{--vedere include nel layout, ho passato il parametro status--}}
{{--{{$status}}--}}
    <div>
        <!-- Preloader -->
        <div class="preloader">
            <div class="preloader-inner">
                <div class="preloader-icon">
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        <!-- /End Preloader -->

        <!-- Start Header Area -->
        <header class="header">
            <div class="navbar-area">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <nav class="navbar navbar-expand-lg">
                                <a class="navbar-brand logo" href="/">
                                    <img class="logo1" src="{{asset('/img/logo.png')}}" alt="LET'S JAM" />
                                </a>
                                <button class="navbar-toggler" type="button" data-toggle="collapse"
                                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                        aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="toggler-icon"></span>
                                    <span class="toggler-icon"></span>
                                    <span class="toggler-icon"></span>
                                </button>

                                <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                    <p class="lang" style="display: none;" > th:text="${#locale}"</p>
                                    <ul id="nav" class="navbar-nav ml-auto">
                                        @auth
                                            @if(Auth::user()->role != 'admin')
                                                <li class="nav-item">
                                                    <a @class(['active' => Request::is('home')]) href="/home">Home</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a @class(['active' => Request::is('musicsheets')]) href="/musicsheets/" >spartiti</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a @class(['active' => Request::is('songs')]) href="/songs/">brani</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a @class(['active' => Request::is('musicsheets/create/')]) href="/musicsheets/create/">crea/carica</a>
                                                </li>
                                                <li  class="nav-item">
                                                    <a @class(['active' => Request::is('aboutUs')]) href="/aboutUs" >about us</a>
                                                </li>
                                            @endif
                                            @elseguest
                                            <li class="nav-item">
                                                <a @class(['active' => Request::is('home')]) href="/home">Home</a>
                                            </li>
                                            <li class="nav-item">
                                                <a @class(['active' => Request::is('musicsheets')]) href="/musicsheets/" >spartiti</a>
                                            </li>
                                            <li class="nav-item">
                                                <a @class(['active' => Request::is('songs')]) href="/songs/">brani</a>
                                            </li>
                                            <li class="nav-item">
                                                <a @class(['active' => Request::is('musicsheets/create/')]) href="/musicsheets/create/">crea/carica</a>
                                            </li>
                                            <li  class="nav-item">
                                                <a @class(['active' => Request::is('aboutUs')]) href="/aboutUs" >about us</a>
                                            </li>
                                        @endauth
                                        @auth
                                            @if(Auth::user()->role == 'admin')
                                                <li class="nav-item">
    {{--                                                le rotte si scrivono cosi--}}
    {{--                                                <a href="{{route('nome della rotta')}}"> Verifica Spartiti </a>--}}
                                                    <a href="/admin/verifyMusicsheet"> Verifica Spartiti </a>
                                                </li>
                                                <li  class="nav-item">
                                                    <a href="/admin/manageUsers" > Gestione Utenti </a>
                                                </li>
                                                @endif
                                                <li class="ml-4 d-flex align-items-center justify-content-end">
                                                    <a class="p-0" href="/profilo">
                                                    @if(Auth::user()->avatar !== '')
                                                        <img src="{{asset(Auth::user()->avatar)}}" alt="profile avatar" class="profile">
                                                    @endif
                                                    @unless(Auth::user()->avatar !== '')
                                                        <img src="https://avatars.dicebear.com/api/male/{{Auth::user()->firstname}}.svg" alt="profile avatar" class="profile">
                                                    @endunless
                                                    </a>
                                                </li>
                                        @endauth

                                    </ul>
                                </div>
                                <!-- navbar collapse -->
                                <div class="button">
                                    @auth
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a onclick="event.preventDefault();
                                                this.closest('form').submit();" class="btn"> Logout </a>
                                        </form>
                                    @endauth
                                    @guest
                                        <a href="/login" class="btn" > Login </a>
                                    @endguest
                                </div>
                            </nav>
                            <!-- navbar -->

                        </div>
                    </div>
                    <!-- row -->
                </div>
                <!-- container -->
            </div>
            <!-- navbar area -->
        </header>
        <!-- End Header Area -->
    </div>
