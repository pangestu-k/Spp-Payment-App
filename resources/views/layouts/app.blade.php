<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Spp Payment App</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <link rel="stylesheet" href="{{asset('assets/css2.css')}}">
    <link rel="stylesheet" href="{{asset('assets/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fontawesome-free-5.15.3-web/css/all.min.css')}}">

    <script src="{{asset('assets/jquery-3.6.0.slim.min.js')}}"></script>
    <script src="{{asset('assets/popper.min.js')}}"></script>
    <script src="{{asset('assets/bootstrap.min.js')}}"></script>

    <script src="{{asset('assets/jquery.min.js')}}"></script>

    <link rel="stylesheet" href="{{asset('assets/jquery.dataTables.css')}}">
    <script src="{{asset('assets/jquery.dataTables.js')}}"></script>

    <link rel="stylesheet" href="{{asset('assets/select2.min.css')}}">
    <script src="{{asset('assets/select2.min.js')}}"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body style="background: lightgrey">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="fas fa-user-astronaut"></i> Spp Payment
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <!-- Link User -->
                        @auth
                            @if (auth()->user()->level == 'admin')
                                <li class="nav-item">
                                    <a class="nav-link {{request()->routeIs('kelas.index') ? 'active' : ''}} @yield('activeKelas')" href="{{ route('kelas.index') }}">Kelas</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link {{request()->routeIs('spp.index') ? 'active' : ''}} @yield('activeSpp')" href="{{ route('spp.index') }}">Spp</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link {{request()->routeIs('petugas.index') ? 'active' : ''}}@yield('activePetugas')" href="{{ route('petugas.index') }}">Petugas</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link {{request()->routeIs('siswa.index') ? 'active' : ''}} @yield('activeSiswa')" href="{{ route('siswa.index') }}">Siswa</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link {{request()->routeIs('pembayaran.index') ? 'active' : ''}} @yield('activePembayaran')" href="{{ route('pembayaran.index') }}">Pembayaran</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link {{request()->routeIs('pembayaran.history') ? 'active' : ''}}" href="{{route('pembayaran.history')}}">History Pembayaran</a>
                                </li>
                            @elseif (auth()->user()->level == 'petugas')
                                <li class="nav-item">
                                    <a class="nav-link {{request()->routeIs('pembayaran.index') ? 'active' : ''}} @yield('activePembayaran')" href="{{ route('pembayaran.index') }}">Pembayaran</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link {{request()->routeIs('pembayaran.history') ? 'active' : ''}} @yield('activeHistory')" href="{{route('pembayaran.history')}}">History Pembayaran</a>
                                </li>
                            @elseif (auth()->user()->level == 'siswa')
                                <li class="nav-item">
                                    <a class="nav-link {{request()->routeIs('pembayaran.history') ? 'active' : ''}}" href="{{route('pembayaran.history')}}">History Pembayaran</a>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <ul class="navbar-nav ml-auto">
                        <!-- Link Authentikasi -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
