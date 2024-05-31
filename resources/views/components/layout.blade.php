<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <header>
        <div class="header-content wrapper">
            <div class="header-logo">
                <h2>Мир цветов</h2>
            </div>
            <div class="header-information">
                <a href="">О нас</a>
                <a href="{{ url('/catalog') }}">Каталог</a>
                <a href="">Где нас найти?</a>
            </div>
        </div>
    </header>
    <div>
        <div class="regBlock wrapper">
        <nav>
            <ul>
                @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
					<a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
					<a href="{{ route('basket') }}">Корзина</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </ul>
        </nav>
        </div>
        {{ $content }}
    </div>
    <footer>
        <div class="footer-content wrapper">
            <div class="footer-logo">
                <h2>Мир цветов</h2>
            </div>
            <div class="footer-information">
                <a href="">О нас</a>
                <a href="">Каталог</a>
                <a href="">Где нас найти?</a>
            </div>
        </div>
    </footer>
</body>
</html>