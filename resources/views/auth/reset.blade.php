@extends('framework')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
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
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Set New Password</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="/password/reset">
                            <fieldset>
                                {!! csrf_field() !!}
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" value="{{ old('email') }}" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Confirm Password" name="password_confirmation" type="password" value="">
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary btn-block">Reset Password</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop