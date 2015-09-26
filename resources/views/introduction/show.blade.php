@extends('framework-introduction')

@section('content')
    <div class="jumbotron jumbotron-full-page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1>{{ $introduction->heading }}</h1>
                    {!! $introduction->message !!}
                    <p><a class="btn btn-primary btn-lg" href="" role="button">Start the story...</a></p>
                </div>
            </div>
        </div>
    </div>
@stop