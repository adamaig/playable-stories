@extends('framework-slide')
    
@section('header-include')

    @if (!empty($slide->story->heading_font))
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family={{ $fonts[$slide->story->heading_font]['link_code'] }}">
        <style>
            h1,h2,h3,h4,h5,h6 {
                font-family: '{{ $fonts[$slide->story->heading_font]['css_name'] }}';
                font-weight: {{ $fonts[$slide->story->heading_font]['bold_weight'] }};
            }
        </style>
    @endif
    @if (!empty($slide->story->body_font))
        @if ( $slide->story->body_font != $slide->story->heading_font )
            <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family={{ $fonts[$slide->story->body_font]['link_code'] }}">
        @endif
        <style>
            body {
                font-family: '{{ $fonts[$slide->story->body_font]['css_name'] }}';
                font-weight: {{ $fonts[$slide->story->body_font]['normal_weight'] }};
            }
        </style>
    @endif
    
    <style>
        /* Background color and font sizes/colors/alignment */
        body {
            background-color: {{ $slide->story->background_color }};
            font-size: {{ $slide->story->body_font_size}}px;
            color: {{ $slide->story->body_font_color}};
        }
            main {
                text-align: {{ $slide->text_alignment }};
            }
            .container {
                text-align: center;
            }
        a, a:hover, a:visited, a:active, a:link {
            color: {{ $slide->story->link_color}};
        }
        .text-primary {
            color: {{ $slide->story->link_color}};
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
            color: {{ $slide->story->button_text_color}};
            background-color: {{ $slide->story->button_background_color}};
        }
            .btn-primary:hover {
                opacity: 0.90;
                filter: alpha(opacity=90); /* For IE8 and earlier */
            }
            .btn-primary:active:hover {
                opacity: 1.0;
                filter: alpha(opacity=100); /* For IE8 and earlier */
            }
    </style>
    
@stop

@section('content')
    
    <main class="content">
        <div class="container-valign-center">
            <div class="container">
            
                <div class="row text-center">
                    <div class="col-xs-6 col-sm-4 col-sm-offset-2">
                        <p style="margin-bottom: 0;">{{ Session::get('story-'.$slide->story->id.'-meter-1-name') }}</p>
                        <h2 class="text-primary" style="margin-top: 0;">
                            @if ( Session::get('story-'.$slide->story->id.'-meter-1-type') == 'currency' ) {{ '$' }}@endif{{ Session::get('story-'.$slide->story->id.'-meter-1-value') }}@if ( Session::get('story-'.$slide->story->id.'-meter-1-type') == 'percentage' ){{ '%' }} @endif
                        </h2>
                    </div>
                    <div class="col-xs-6 col-sm-4">
                        <p style="margin-bottom: 0;">{{ Session::get('story-'.$slide->story->id.'-meter-2-name') }}</p>
                        <h2 class="text-primary" style="margin-top: 0;">
                            @if ( Session::get('story-'.$slide->story->id.'-meter-2-type') == 'currency' ) {{ '$' }}@endif{{ Session::get('story-'.$slide->story->id.'-meter-2-value')}}@if ( Session::get('story-'.$slide->story->id.'-meter-2-type') == 'percentage' ){{ '%' }} @endif
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h1>{{ $heading }}</h1>
                        {!! $text !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <p><a class="btn btn-lg btn-primary" href="/story/{{ $story->id }}" role="button">Play again</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop