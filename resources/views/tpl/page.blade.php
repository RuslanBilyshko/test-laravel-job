<!DOCTYPE HTML>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>{{$head_title}}</title>

  <script src="/js/jquery-1.11.3.min.js"></script>
  <!--скрипт для старых браузеров IE-->
  <!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->


  <script src="/libs/kalendar/jquery-ui.js"></script>
  <link href="/libs/kalendar/jquery-ui.css" rel="stylesheet">
  <script src="/libs/maskedinput/jquery.maskedinput.min.js"></script>
  <script src="/js/common.js"></script>

  <link href="/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/libs/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="/css/style.css" rel="stylesheet">

</head>
  <body>
    <div class="container wrapper">
      <div class="row">
        <header class="col-md-12">
          <h1>{{$site_name}}</h1>
          @include('user-menu')
        </header>

        <main class="col-md-4 col-md-offset-4">
          <div class="message">
            @include('tpl.message')
          </div>
          <header>
            <h2>{{$title}}</h2>
          </header>
          <article class="content-wrapper">
            {!! render($content) !!}
          </article>
        </main>
        <footer class="col-md-4 col-md-offset-4">
         <p>Footer</p>
        </footer>
      </div>
    </div>
  </body>
</html>