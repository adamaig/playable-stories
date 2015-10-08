@extends('framework-introduction')

@section('header-include')
    @if (!empty($introduction->story->heading_font))
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family={{ $introduction->story->heading_font }}">
        <style>
            h1,h2,h3,h4,h5,h6 {
                font-family: '{{ $fonts[$introduction->story->heading_font] }}';
            }
        </style>
    @endif
    @if (!empty($introduction->story->body_font))
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family={{ $introduction->story->body_font }}">
        <style>
            body {
                font-family: '{{ $fonts[$introduction->story->body_font] }}';
            }
        </style>
    @endif
    <style>
        /* Background color and font sizes/colors/alignment */
        body {
            background-color: {{ $introduction->background_color }};
            font-size: {{ $introduction->story->body_font_size}}px;
            text-align: {{ $introduction->text_alignment }};
            color: {{ $introduction->story->body_font_color}};
        }
        a, a:hover, a:visited, a:active, a:link {
            color: {{ $introduction->story->link_color}};
        }
        
        /* Navbars */
        .navbar {
            display: none;
        }
        
        /* Buttons */
        .btn-primary,
        .btn-primary:hover,
        .btn-primary:visited,
        .btn-primary:active,
        .btn-primary:active:focus,
        .btn-primary:active:hover,
        .btn-primary:focus,
        .btn-primary:link {
            color: {{ $introduction->story->button_text_color}};
            background-color: {{ $introduction->story->button_background_color}};
        }
            .btn-primary:hover {
                opacity: 0.90;
                filter: alpha(opacity=90); /* For IE8 and earlier */
            }
            .btn-primary:active:hover {
                opacity: 1.0;
                filter: alpha(opacity=100); /* For IE8 and earlier */
            }
        
        /* Background image */
        .container-valign-center {
            @if (!empty($introduction->photo) && $introduction->photo_type == 'background')
                background-image: url('/img/introduction-photos/{{ $introduction->photo }}');
            @endif

            @if (!empty($introduction->photo) && $introduction->background_placement == 'left_top' && $introduction->photo_type == 'background')
                background-position: left top;
            @elseif (!empty($introduction->photo) && $introduction->background_placement == 'center_top' && $introduction->photo_type == 'background')
                background-position: center top;
            @endif

            @if (!empty($introduction->photo) && $introduction->background_placement == 'tile' && $introduction->photo_type == 'background')
                background-repeat: repeat;
            @else
                background-repeat: no-repeat;
            @endif

            @if (!empty($introduction->photo) && $introduction->background_placement == 'fill' && $introduction->photo_type == 'background')
                background-size: cover;
            @endif
        }
    </style>
@stop

@section('content')
    
    <main class="content">
        <div class="container-valign-center">
            <div class="container">
            
                <div class="row">
                    <div class="col-xs-12">
                        @if (!empty($introduction->photo) && $introduction->photo_type == 'above')
                            <img src="/img/introduction-photos/{{ $introduction->photo }}" alt="{{ $introduction->story->name }} Introduction" class="introduction-photo" />
                        @endif
                        <h1>{{ $introduction->heading }}</h1>
                        {!! $introduction->message !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <p><a class="btn btn-primary btn-lg" href="/story/{{ $introduction->story->id }}/1" role="button">Start the story...</a></p>
                    </div>
                </div>
                @if (!empty($introduction->photo) && $introduction->photo_type == 'below')
                    <div class="row">
                        <div class="col-xs-12">
                            <img src="/img/introduction-photos/{{ $introduction->photo }}" alt="{{ $introduction->story->name }} Introduction" class="introduction-photo" />
                        </div>
                    </div>
                @endif
                
            </div>
        </div>
    </main>
    
@stop