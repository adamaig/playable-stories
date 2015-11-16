@extends('framework')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                @if (Session::has('status'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ Session::get('status') }}
                    </div>
                @endif
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
                <form method="POST" action="/password/email">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        Email
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-default">Send Password Reset Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop