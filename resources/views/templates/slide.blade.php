@extends('framework-story')
    
@section('header-include')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content')
    <div class="jumbotron jumbotron-full-page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <img src="http://user10.com/wp-content/uploads/2015/08/team-user10.jpg" />
                    <h1>[Slide header text]</h1>
                    <p>[Slide message] Phasellus eget libero auctor, varius tellus vel, tristique metus. Mauris auctor nibh sed nulla venenatis condimentum. Sed eleifend sapien est, a condimentum eros lacinia malesuada. Fusce imperdiet risus nec placerat aliquam. Pellentesque ut scelerisque lacus, a pharetra dui.</p>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-xs-12 col-sm-4 col-sm-offset-2">
                    <p><a href="">Mike</a></p>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <p><a href="">Andrew</a></p>
                </div>
                <div class="col-xs-12 col-sm-4 col-sm-offset-2">
                    <p><a href="">Brad</a></p>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <p><a href="">Josh</a></p>
                </div>
            </div>
        </div>
    </div>
@stop