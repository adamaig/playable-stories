@extends('framework-slide')
    
@section('header-include')
    <style>
        @if ($slide->text_placement == 'overlay')
            #slide-image-container {
                display: inline-block;
                position: relative;
                background: url('/img/slide-photos/{{ $slide->image }}') no-repeat;
            }
            #slide-image {
                opacity: 0;
            }
            #text-overlay {
                position: absolute;
                padding: 15px;
            }
        @endif
    </style>
@stop

@section('content')
    <div class="jumbotron jumbotron-full-page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    @if (!empty($slide->image))
                        <div id="slide-image-container">
                            @if ($slide->text_placement == 'overlay')
                                <div id="text-overlay">{!! $slide->content !!}</div>
                            @endif
                            <img src="/img/slide-photos/{{ $slide->image }}" id="slide-image" alt="" />
                        </div>
                    @endif
                    @if (empty($slide->image) || $slide->text_placement == 'under')
                        {!! $slide->content !!}
                    @endif
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