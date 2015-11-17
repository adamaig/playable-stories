@extends('framework')

@section('header-include')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('navbar-right')
    <div id="navbar" class="navbar-collapse collapse">
        <div class="navbar-right">
            <a href="/story/create" class="btn btn-sm btn-primary navbar-btn">New Story</a>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        @if (Session::pull('password_change') == 'true')
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                Your password has been changed successfully.
            </div>
        @endif
        @include('flash::message')
        @if (count($stories) == 0)
            <div class="jumbotron">
                <h1>Let's build some awesome stories!</h1>
                <p>We'll guide you through the process of creating an inteactive news story. What are you waiting for?</p>
                <p><a class="btn btn-primary btn-lg" href="/story/create" role="button">Get Started</a></p>
            </div>
        @else
            @foreach ($stories as $story)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="pull-left">
                            <h4>{{ $story->name }}</h4>
                            View at: <a href="/story/{{ $story->id }}" target="_blank">{{ getenv('APP_URL') }}/story/{{ $story->id }}</a>
                        </div>
                        <div class="btn-group pull-right" role="group" aria-label="...">
                            <a class="btn btn-default" href="/story/{{ $story->id }}/edit">Edit</a>
                            <a class="btn btn-default" href="javascript:deleteStory('{{ $story->id }}')">Delete</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@stop

@section('footer-include')
    <script>
        function deleteStory(id) {
            if (confirm('Delete this story?')) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "DELETE",
                    url: 'story/' + id,
                    success: function(affectedRows) {
                        if (affectedRows > 0) window.location = '/';
                    }
                });
            }
        }
    </script>
@stop