@extends('framework-slide')
    
@section('header-include')
    <style>
        .navbar {
            display: none;
        }
        .jumbotron {
            text-align: center;
        }
    </style>
@stop

@section('content')
    <div class="jumbotron jumbotron-full-page">
        <div class="container">
            <div class="row text-center">
                <div class="col-xs-6 col-sm-4 col-sm-offset-2">
                    <p>{{ Session::get('story-'.$story->id.'-meter-1-name') }}</p>
                    <hr />
                    <h2>{{ Session::get('story-'.$story->id.'-meter-1-value') }}</h2>
                </div>
                <div class="col-xs-6 col-sm-4">
                    <p>{{ Session::get('story-'.$story->id.'-meter-2-name') }}</p>
                    <hr />
                    <h2>{{ Session::get('story-'.$story->id.'-meter-2-value') }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <h1>{{ $heading }}</h1>
                    {!! $text !!}
                    <p><a class="btn btn-primary btn-lg" href="/story/{{ $story->id }}" role="button">Play again</a></p>
                </div>
            </div>
        </div>
    </div>
@stop