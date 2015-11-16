<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <title>Playable Stories</title>

        <!-- Bootstrap -->
        <link href="/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="/css/app.css">

        @yield('header-include')

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <!-- Static navbar -->
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">Playable Stories</a>
                    @if(Auth::check())
                        <a id="logout-link" href="/auth/logout">sign out</a>
                    @endif
                </div>
                @yield('navbar-right')
            </div>
        </nav>

        @yield('content')

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>

        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="/bootstrap/dist/js/bootstrap.min.js"></script>

        @yield('footer-include')
    </body>
</html>