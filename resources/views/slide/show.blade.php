@extends('framework-slide')
    
@section('header-include')
    <style>
        .jumbotron-full-page {
            text-align: center;
            background-color: {{ $slide->story->background_color }};
        }
        #text-overlay, #slide-text, .jumbotron p {
            text-align: {{ $slide->text_alignment }};
            font-size: {{ $slide->story->body_font_size}}px;
            color: {{ $slide->story->body_font_color}};
        }
        a, a:hover, a:visited, a:active, a:link {
            color: {{ $slide->story->link_color}};
        }
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
{{ Session::get('vignette') }}
    @if (Session::has('vignette'))
        <div class="modal modal-valign-center fade" id="vignette" tabindex="-1" role="dialog" aria-labelledby="vignetteLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="row">
                            <div class="col-xs-12">
                                {!! Session::pull('vignette') !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Continue</button>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    @endif

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
                        <div id="slide-text">{!! $slide->content !!}</div>
                    @endif
                </div>
            </div>
            <div class="row text-center">
                @foreach ($slide->choices()->get() as $key => $choice)
                    <div class="col-xs-12 col-sm-4 @if (($key+1) & 1) {{ 'col-sm-offset-2' }} @endif">
                        <p><a href="/story/{{ $slide->story->id }}/{{ $slide->order }}/choice/{{ $choice->id}}">{{ $choice->text }}</a></p>
                    </div>
                @endforeach

                @if (count($slide->choices()->get()) == 0)
                    <p><a href="/story/{{ $slide->story->id }}/{{ $slide->order+1 }}">Continue</a></p>
                @endif
            </div>
        </div>
    </div>
@stop

@section('footer-include')
    <script>
        @if (Session::has('vignette'))
            // Vertically center our modals
            function centerModals($element) {
                var $modals;
                
                if ($element.length) {
                    $modals = $element;
                } else {
                    $modals = $('.modal-valign-center:visible');
                }
                
                $modals.each( function(i) {
                    var $clone = $(this).clone().css('display', 'block').appendTo('body');
                    var top = Math.round(($clone.height() - $clone.find('.modal-content').height()) / 2);
                    top = top > 0 ? top : 0;
                    $clone.remove();
                    $(this).find('.modal-content').css("margin-top", top);
                });
            }
            
            $('.modal-valign-center').on('show.bs.modal', function(e) {
                centerModals($(this));
            });
            
            $(window).on('resize', centerModals);
            
            $('#vignette').modal('show');
        @endif
    </script>
@stop