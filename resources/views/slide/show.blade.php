@extends('framework-slide')
    
@section('header-include')


    
@stop

@section('content')

    @if (!empty(session('vignette')))
        <div class="modal modal-valign-center fade" id="vignette" tabindex="-1" role="dialog" aria-labelledby="vignetteLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="row">
                            <div class="col-xs-12">
                                {!! session('vignette') !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button type="button" class="btn btn-lg btn-primary" data-dismiss="modal">Continue</button>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    @endif
    
    <main class="content">
        <div class="container-valign-center">
            <div class="container">
                
                @if ($slide->text_placement == 'under')
                    @if (!empty($slide->image))
                        <div class="row">
                            <div id="slide-image-container" class="col-xs-12">
                                <img src="/img/slide-photos/{{ $slide->image }}" id="slide-image" alt="" />
                            </div>
                        </div>
                    @endif
                    @if (empty($slide->image) || $slide->text_placement == 'under')
                        <div class="row">
                            <div id="slide-text" class="col-xs-12">
                                {!! $slide->content !!}
                            </div>
                        </div>
                    @endif
                    <div class="row text-center">
                        @foreach ($slide->choices()->get() as $key => $choice)
                            @if (count($slide->choices()->get()) == 3)
                                <div class="col-xs-12 col-sm-4">
                                    <p><a href="/story/{{ $slide->story->id }}/{{ $slide->order }}/choice/{{ $choice->id}}">{{ $choice->text }}</a></p>
                                </div>
                            @else
                                <div class="col-xs-12 col-sm-4 @if (($key+1) & 1) {{ 'col-sm-offset-2' }} @endif">
                                    <p><a href="/story/{{ $slide->story->id }}/{{ $slide->order }}/choice/{{ $choice->id}}">{{ $choice->text }}</a></p>
                                </div>
                            @endif
                        @endforeach
        
                        @if (count($slide->choices()->get()) == 0)
                            <p><a class="btn btn-lg btn-primary" href="/story/{{ $slide->story->id }}/{{ $slide->order+1 }}">Continue</a></p>
                        @endif
                    </div>
                @else
                    <div class="row">
                        <div id="slide-image-container" class="col-xs-12 col-sm-6 @if ($slide->text_placement == 'left') {{ 'col-sm-push-6' }} @endif">
                            <img src="/img/slide-photos/{{ $slide->image }}" id="slide-image" alt="" />
                        </div>
                        <div id="slide-text" class="col-xs-12 col-sm-6 @if ($slide->text_placement == 'left') {{ 'col-sm-pull-6' }} @endif">
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! $slide->content !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    @if (count($slide->choices()->get()) == 0)
                                        <p><a class="btn btn-lg btn-primary" href="/story/{{ $slide->story->id }}/{{ $slide->order+1 }}">Continue</a></p>
                                    @else
                                        @foreach ($slide->choices()->get() as $key => $choice)
                                            <p><a href="/story/{{ $slide->story->id }}/{{ $slide->order }}/choice/{{ $choice->id}}">{{ $choice->text }}</a></p>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
            </div>
        </div>
    </main>
    
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