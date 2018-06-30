<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    <title>@yield('title') - {{ config('app.name') }}</title>
        <script src="/assets/js/jquery-2.2.4.min.js" defer></script>
        <script src="/assets/js/bootstrap.min.js" defer></script>
        <script src="/assets/js/js.cookie.js" defer></script>
        <script src="/assets/js/shop-laravel.js" defer></script>
        <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="/assets/css/shop_laravel.css">
    </head>
    <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Shop Laravel</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/">{{ trans('shop.home') }}</a></li>
                    <li><a href="#">{{ trans('blog.home') }}</a></li>
                    <li><a href="/merchandise">{{ trans('shop.merchandise.list') }}</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#">
                            <span class="set_language" data-language="zh-TW">
                                中文
                            </span>
                            /
                            <span class="set_language" data-language="en">
                                English
                            </span>
                        </a>
                    </li>
                    @if(Auth::check())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ trans('shop.transaction.name') }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/transaction">{{ trans('shop.transaction.list') }}</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <form class="form-inline" action="{{ route('logout')}}" method="POST">
                                        {{ csrf_field() }}
                                        <input class="btn" type="submit" value="{{ trans('shop.auth.sign-out') }}">
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ trans('shop.auth.sign-in') }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/login">{{ trans('shop.auth.general-sign-in') }}</a></li>
                                <li><a href="/user/auth/facebook-sign-in">{{ trans('shop.auth.facebook-sign-in') }}</a></li>
                            </ul>
                        </li>
                        <li><a href="/register">{{ trans('shop.auth.sign-up') }}</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    </body>
</html>