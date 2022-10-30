<!doctype html>
<html lang="en">
  <head>
  	<title>Knowledge base</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{asset ('js/popper.js') }}"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="{{asset('js/jquery.treetable.js')}}"></script>

    <link rel="stylesheet" href="{{asset('css/jquery.treetable.theme.default.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		<link href="{{ asset ('css/jquery.treetable.css') }}" rel="stylesheet" type="text/css" />

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--<link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">




  </head>
  <body>


    <div class="wrapper d-flex align-items-stretch">


        <!-- Page Content  -->
            <div id="content" class=" p-4 p-md-5 pt-5">
                @yield('content')
            </div>
		</div>


    <script src="{{ asset('js/popper.js') }}"></script>
  </body>
</html>
