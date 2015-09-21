@extends('framework')

@section('header-include')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('navbar-right')
    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
            <li><a href="/story/create" class="btn btn-primary">New Story</a></li>
        </ul>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                @include('flash::message')
                @foreach ($stories as $story)
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="pull-left">
                                <h4>{{ $story->name }}</h4>
                                View at: <a href="/story/{{ $story->id }}" target="_blank">{{ getenv('APP_URL') }}/story/{{ $story->id }}</a>
                            </div>
                            <div class="btn-group btn-group-lg pull-right" role="group" aria-label="...">
                                <a class="btn btn-default" href="/story/{{ $story->id }}/edit">Edit</a>
                                <a class="btn btn-default">Duplicate</a>
                                <a class="btn btn-default" href="javascript:deleteStory('{{ $story->id }}')">Delete</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
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