@extends('framework-group')

@section('header-include')
    @if (!empty($story->heading_font))
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family={{ $fonts[$story->heading_font]['link_code'] }}">
        <style>
            h1,h2,h3,h4,h5,h6 {
                font-family: '{{ $fonts[$story->heading_font]['css_name'] }}';
                font-weight: {{ $fonts[$story->heading_font]['bold_weight'] }};
                color: {{ $story->heading_font_color }};
            }
            .content .container {
                text-align: {{ $group->text_alignment }};
            }
        </style>
    @endif
    @if (!empty($story->body_font))
        @if ( $story->body_font != $story->heading_font )
            <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family={{ $fonts[$story->body_font]['link_code'] }}">
        @endif
        <style>
            body {
                font-family: '{{ $fonts[$story->body_font]['css_name'] }}';
                font-weight: {{ $fonts[$story->body_font]['normal_weight'] }};
            }
        </style>
    @endif
    <style>
        /* Background color and font sizes/colors/alignment */
        body {
            background-color: {{ $group->background_color }};
            font-size: {{ $story->body_font_size }}px;
            color: {{ $story->body_font_color }};
        }
        a, a:hover, a:visited, a:active, a:link {
            color: {{ $story->link_color }};
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
            color: {{ $story->button_text_color }};
            background-color: {{ $story->button_background_color }};
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
            @if (!empty($group->photo) && $group->photo_type == 'background')
                background-image: url('/img/group-photos/{{ $group->photo }}');
            @endif

            @if (!empty($group->photo) && $group->background_placement == 'left_top' && $group->photo_type == 'background')
                background-position: left top;
            @elseif (!empty($group->photo) && $group->background_placement == 'center_top' && $group->photo_type == 'background')
                background-position: center top;
            @endif

            @if (!empty($group->photo) && $group->background_placement == 'tile' && $group->photo_type == 'background')
                background-repeat: repeat;
            @else
                background-repeat: no-repeat;
            @endif

            @if (!empty($group->photo) && $group->background_placement == 'fill' && $group->photo_type == 'background')
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
                        @if (!empty($group->photo) && $group->photo_type == 'above')
                            <img src="/img/group-photos/{{ $group->photo }}" alt="{{ $story->name }} group" class="group-photo" />
                        @endif
                        {!! $group->message !!}
                    </div>
                </div>
                <div class="row">
                    @foreach ($paths as $key => $path)
                        @if (count($paths) == 3)
                            <div class="col-xs-12 col-sm-4">
                                <p><a href="/story/{{ $path->id }}" class="btn btn-primary btn-lg">@if ($path->pivot->button_name) {{ $path->pivot->button_name }} @else {{ $path->name }} @endif</a></p>
                            </div>
                        @else
                            <div class="col-xs-12 col-sm-4 @if (($key+1) & 1) {{ 'col-sm-offset-2' }} @endif">
                                <p><a href="/story/{{ $path->id }}" class="btn btn-primary btn-lg">@if ($path->pivot->button_name) {{ $path->pivot->button_name }} @else {{ $path->name }} @endif</a></p>
                            </div>
                        @endif
                    @endforeach
                </div>
                @if (!empty($group->photo) && $group->photo_type == 'below')
                    <div class="row">
                        <div class="col-xs-12">
                            <img src="/img/group-photos/{{ $group->photo }}" alt="{{ $story->name }} group" class="group-photo" />
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </main>

@stop