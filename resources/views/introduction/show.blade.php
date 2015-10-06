@extends('framework-introduction')

@section('header-include')
    @if (!empty($introduction->story->heading_font))
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family={{ $introduction->story->heading_font }}">
        <style>
            h1,h2,h3,h4,h5,h6 {
                font-family: {{ $fonts[$introduction->story->heading_font] }};
            }
        </style>
    @endif
    @if (!empty($introduction->story->body_font))
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family={{ $introduction->story->body_font }}">
        <style>
            body {
                font-family: {{ $fonts[$introduction->story->body_font] }};
            }
        </style>
    @endif
    <style>
        .navbar {
            display: none;
        }
        .story-view .jumbotron {
            background-color: {{ $introduction->background_color }};
            text-align: {{ $introduction->text_alignment }};
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
    <div class="jumbotron jumbotron-full-page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    @if (!empty($introduction->photo) && $introduction->photo_type == 'above')
                        <img src="/img/introduction-photos/{{ $introduction->photo }}" alt="{{ $introduction->story->name }} Introduction" class="introduction-photo" />
                    @endif
                    <h1>{{ $introduction->heading }}</h1>
                    {!! $introduction->message !!}
                    <p><a class="btn btn-primary btn-lg" href="/story/{{ $introduction->story->id }}/1" role="button">Start the story...</a></p>
                    @if (!empty($introduction->photo) && $introduction->photo_type == 'below')
                        <img src="/img/introduction-photos/{{ $introduction->photo }}" alt="{{ $introduction->story->name }} Introduction" class="introduction-photo" />
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop