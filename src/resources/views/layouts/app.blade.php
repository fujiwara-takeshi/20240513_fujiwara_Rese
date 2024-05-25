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
                    <a class="logo__link" href="">Rese</a>
                </div>
            </div>
            <div class="header__inner-right">
                @yield('search')
            </div>
        </div>
    </header>

    <main class="main">
        <div class="content">
            <div class="content__inner">
                @yield('content')
            </div>
        </div>

        <div class="modal" id="modal">
            <div class="modal__inner">
                <div class="modal__header">
                    <a href="#" class="modal__close-button">
                        <i class="material-symbols-outlined close-icon">close</i>
                    </a>
                </div>
                <div class="modal__content">
                    <div class="modal__link-item">
                        <a href="" class="modal__link link-home">Home</a>
                    </div>
                    <div class="modal__link-item">
                        <a href="" class="modal__link link-logout">Logout</a>
                    </div>
                    <div class="modal__link-item">
                        <a href="" class="modal__link link-mypage">Mypage</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>