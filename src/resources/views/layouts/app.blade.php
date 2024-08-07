<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__inner-left">
                <div class="header__logo">
                    <a class="logo__menu-icon" href="#modal">
                        <i class="material-symbols-outlined menu-icon">menu</i>
                    </a>
                    <a class="logo__link" href="{{ route('shop.index') }}">Rese</a>
                </div>
            </div>
            <div class="header__inner-right">
                @yield('header__inner-right')
            </div>
        </div>
    </header>

    <main class="main">
        <div class="content">
            <div class="content__inner">
                @yield('content')
            </div>
        </div>

        @if (Auth::check())
        <div class="modal" id="modal">
            <div class="modal__inner">
                <div class="modal__header">
                    <a class="modal__close-button" href="#">
                        <i class="material-symbols-outlined close-icon">close</i>
                    </a>
                </div>
                <div class="modal__content">
                    <div class="modal__link-item">
                        <a class="modal__link link-home" href="{{ route('shop.index') }}">Home</a>
                    </div>
                    <div class="modal__link-item">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="modal__link button-logout">Logout</button>
                        </form>
                    </div>
                    <div class="modal__link-item">
                        <a class="modal__link link-mypage" href="{{ route('user.index', ['user_id' => Auth::id()]) }}">Mypage</a>
                    </div>
                </div>
            </div>
        </div>

        @else
        <div class="modal" id="modal">
            <div class="modal__inner">
                <div class="modal__header">
                    <a class="modal__close-button" href="#">
                        <i class="material-symbols-outlined close-icon">close</i>
                    </a>
                </div>
                <div class="modal__content">
                    <div class="modal__link-item">
                        <a class="modal__link link-home" href="{{ route('shop.index') }}">Home</a>
                    </div>
                    <div class="modal__link-item">
                        <a class="modal__link link-registration" href="{{ route('register') }}">Registration</a>
                    </div>
                    <div class="modal__link-item">
                        <a class="modal__link link-login" href="{{ route('login') }}" >Login</a>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </main>

</body>
</html>