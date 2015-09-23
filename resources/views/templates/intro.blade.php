@extends('framework-story')
    
@section('header-include')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content')
    <div class="jumbotron jumbotron-full-page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1>[Introduction slide header text]</h1>
                    <p>[Introduction slide message] Duis posuere convallis dapibus. Integer at eros turpis. Morbi faucibus elementum nunc, sed venenatis odio pharetra vitae. In hac habitasse platea dictumst. Nam eget nulla lobortis elit tristique gravida. Phasellus eget libero auctor, varius tellus vel, tristique metus. Mauris auctor nibh sed nulla venenatis condimentum.</p>
                    <p><a class="btn btn-primary btn-lg" href="" role="button">Start the story...</a></p>
                </div>
            </div>
        </div>
    </div>
@stop