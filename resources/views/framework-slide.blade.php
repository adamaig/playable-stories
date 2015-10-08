<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        
        <title>{{ $slide->story->name }}</title>

        <!-- Bootstrap -->
        <link href="/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        
        <link rel="stylesheet" href="/css/app.css">
        
        <style>
            /* Format the meter styles with the global story styles. */
            .navbar-default .navbar-text {
                color: {{ $slide->story->body_font_color}};
            }
            .navbar-fixed-top .navbar-text .lead {
                color: {{ $slide->story->link_color}};
            }
        </style>
        
        @yield('header-include')

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    
    <body class="story-view">

        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-left">
                    <p class="navbar-text">
                        {{ Session::get('story-'.$slide->story->id.'-meter-1-name') }}
                        <br />
                        <span class="lead">
                            @if ( Session::get('story-'.$slide->story->id.'-meter-1-type') == 'currency' ) {{ '$' }}@endif{{ Session::get('story-'.$slide->story->id.'-meter-1-value') }}@if ( Session::get('story-'.$slide->story->id.'-meter-1-type') == 'percentage' ){{ '%' }} @endif
                        </span>
                    </p>
                </div>
                <div class="navbar-right">
                    <p class="navbar-text text-right">
                        {{ Session::get('story-'.$slide->story->id.'-meter-2-name') }}
                        <br />
                        <span class="lead">
                            @if ( Session::get('story-'.$slide->story->id.'-meter-2-type') == 'currency' ) {{ '$' }}@endif{{ Session::get('story-'.$slide->story->id.'-meter-2-value')}}@if ( Session::get('story-'.$slide->story->id.'-meter-2-type') == 'percentage' ){{ '%' }} @endif
                        </span>
                    </p>
                </div>
            </div>
        </nav>
        
        @yield('content')
    
        <nav class="navbar navbar-default navbar-fixed-bottom">
            <div class="container">
                <div class="navbar-center">
                    <p class="navbar-text text-center"><a href="/">Exit</a>&nbsp;&nbsp;/&nbsp;&nbsp;Built with Playable Stories</p>
                </div>
            </div>
        </nav>
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
        
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="/bootstrap/dist/js/bootstrap.min.js"></script>
        
        @yield('footer-include')
    </body>
</html>