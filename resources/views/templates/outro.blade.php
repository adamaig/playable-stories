@extends('framework-story')
    
@section('header-include')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content')
    <div class="jumbotron jumbotron-full-page">
        <div class="container">
            <div class="row text-center">
                <div class="col-xs-6 col-sm-4 col-sm-offset-2">
                    <p>[Meter Name] Cash</p>
                    <hr />
                    <h2>$1,000</h2>
                </div>
                <div class="col-xs-6 col-sm-4">
                    <p>[Meter Name] Days</p>
                    <hr />
                    <h2>1</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <h1>[Outro slide header text]</h1>
                    <p>[Outro slide message] Ut vitae velit vitae ipsum tristique auctor eu vitae justo. Aliquam imperdiet lectus a nunc malesuada scelerisque. Duis in tortor magna. Proin sed odio placerat, vulputate nisl eget, faucibus enim. Phasellus pretium ligula eget mollis sagittis. Pellentesque et erat ex. Nam lacinia nunc quis dolor elementum tempor.</p>
                    <p><a class="btn btn-primary btn-lg" href="" role="button">Play again</a></p>
                </div>
            </div>
        </div>
    </div>
@stop