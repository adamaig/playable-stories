@extends('framework')

@section('navbar-right')
    <div id="navbar" class="navbar-collapse collapse">
        <div class="navbar-right">
            <a href="/auth/login" class="btn btn-sm btn-primary navbar-btn">Log In</a>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>Create Account</h1>
                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Uh oh!</strong> We have run into some problems:
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="/auth/register">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        Name
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        Email
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        Password
                        <input type="password" class="form-control" name="password" id="password">
                    </div>

                    <div class="form-group">
                        Confirm Password
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-default">Create Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop