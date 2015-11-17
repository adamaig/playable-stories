@extends('framework')

@section('navbar-right')
    <div id="navbar" class="navbar-collapse collapse">
        <div class="navbar-right">
            <a href="/auth/register" class="btn btn-sm btn-primary navbar-btn">Create Account</a>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>Log In</h1>
                @include('flash::message')
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
                <form method="POST" action="/auth/login">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        Email
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        Password
                        <input type="password" class="form-control" name="password" id="password">
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                      </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-default">Login</button>
                    </div>
                    <p class="help-block"><a href="/password/email">Forgot your password?</a></p>
                </form>
            </div>
        </div>
    </div>
@stop