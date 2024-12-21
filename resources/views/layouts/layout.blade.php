<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <link rel="icon" href="https://img.icons8.com/ios-filled/100/FA5252/star--v1.png" type="image/png">
    <title> @section('title') @show
    </title>


    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom css -->
    <link rel="stylesheet" href="/css/style.css">

    <meta name="theme-color" content="#7952b3">
</head>

<body>

    <header>
            <div class="collapse bg-dark" id="navbarHeader">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-md-7 py-4">
                            <h4 class="text-white">Сделаем лучше вместе!</h4>
                            @guest
                            <p class="text-muted">Для полной работы функйионала необходимо зарегестрироваться!</p>
                            @endguest

                            @auth
                                <p class="text-white">Теперь Вы можете оставить заявку :)</p>
                            @endauth
                        </div>
                        <div class="col-sm-4 offset-md-1 py-4">
                            <ul class="list-unstyled">
                                @auth
                                    <li><a href="{{ route('profile') }}">Личный кабинет</a></li>
                                    <li><a href="{{ route('logout') }}">Выйти</a></li>
                                    <li class="text-white">
                                        {{ auth()->user()->name }}
                                    </li>
                                    <li>
                                        {{-- <img src="{{ asset(auth()->user()->avatar) }}" height="60px" width="60px"> --}}
                                        <img src="{{ asset( auth()->user()->avatar) }}" height="60px" width="60px">
                                    </li>
                                @endauth

                                @guest
                                    <li><a href="{{ route('users.create') }}">Регистрация</a></li>
                                    <li><a href="{{ route('loginform') }}">Войти</a></li>
                                @endguest
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar navbar-dark bg-dark shadow-sm">
                <div class="container">
                    <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center">
                        <strong>Портал</strong>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
                        aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
    </header>

    <main>

        @yield('content')

    </main>

    @include('layouts.footer')


    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>


</body>

</html>
