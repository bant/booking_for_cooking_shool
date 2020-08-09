<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="format-detection" content="telephone=yes">
    <meta name="description" content="住吉教室(栗田クッキングサロン)予約">
    <title>管理者ページ</title>
	  <link rel="alternate" hreflang="ja">
	  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="{{ asset('css/kurita_style.css') }}" rel="stylesheet">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>管理者ページ</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- full calendar -->
    <link href='https://unpkg.com/@fullcalendar/core@4.3.1/main.min.css' rel='stylesheet' />
    <link href='https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.css' rel='stylesheet' />
    <link href='https://unpkg.com/@fullcalendar/timegrid@4.3.0/main.min.css' rel='stylesheet' />
    <link href='https://unpkg.com/@fullcalendar/list@4.3.0/main.min.css' rel='stylesheet' />
    <script src='https://unpkg.com/@fullcalendar/core@4.3.1/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/interaction@4.3.0/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/timegrid@4.3.0/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/list@4.3.0/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/core/locales/ja'></script>

    <link href="{{ asset('css/calendar.css') }}" rel="stylesheet">
    
    <!-- UltraDateの読み込み -->
    <script src="{{ asset('js/UltraDate.js') }}"></script>
    <script src="{{ asset('js/UltraDate.ja.js') }}"></script>

    <link href="{{ asset('css/kurita_style.css') }}" rel="stylesheet">

  </head>
  <body>
    <noscript style="color: white">本サイトでは、JavaScript が重要な機能を持っています。是非、有効化してください。</noscript>
    <article>
      <div id="wrapper">
        <header>
          @include('layouts.admin.header')
        </header>

        <div id="container">
          <nav>
            @include('layouts.admin.nav')
          </nav>
    
          <article>
            @yield('content')
          </article>
          <aside>
            @include('layouts.admin.aside')
          </aside>
        </div><!-- #container -->
  
        <footer>
          @include('layouts.admin.footer')
        </footer>
      </div><!-- #wrapper -->
    </article>
    @yield('scripts')
  </body>
</html>
