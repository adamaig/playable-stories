@extends('framework')

@section('header-include')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('navbar-right')
    <div id="navbar" class="navbar-collapse collapse">
        <div class="navbar-right">
            <a href="" class="navbar-btn btn btn-default" target="_blank">Delete</a>
            <a href="" class="navbar-btn btn btn-primary" id="save-button">Save</a>
            <a href="" class="navbar-btn btn btn-primary" >Preview</a>
        </div>
    </div>
@stop

@section('content')
    <div class="modal fade" id="add-choice-modal" tabindex="-1" role="dialog" aria-labelledby="Add a choice">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="/slide/{{ $slide->id }}/choice" id="choice-add-form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">What type of choice would you like to add?</h4>
                    </div>
                    <div class="modal-body">
                        <div class="radio">
                            <label>
                                <input type="radio" name="choice-type" id="chance" value="chance" checked>
                                Probability: This choice may results in one of two outcomes based on chance.
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="choice-type" id="chance" value="specific">
                                Specific: This choice will have specific outcomes on the meter(s).
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="choice-type" id="none" value="none">
                                None: This choice will have no outcomes on the meter(s).
                            </label>
                        </div>
                        {!! csrf_field() !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Choice</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                @include('partials.input-errors')
                @include('flash::message')
                <p><a href="/story/{{ $slide->story->id }}/edit"><i class="fa fa-angle-left"></i> Back to storyline</a></p>
            </div>
        </div>

        <form method="POST" action="/slide/{{ $slide->id }}" id="slide-form" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="name">Slide Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $slide->name }}">
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image">
                    </div>

                    <div class="form-group">
                        <label>Text</label>
                        <textarea class="form-control wysiwyg" rows="3" name="content">{{ $slide->content }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label>Text Placement</label>
                        <select class="form-control" name="text-placement">
                            <option value="overlay" @if ($slide->text_placement == 'overlay') {{ 'selected' }} @endif>Overlay</option>
                            <option value="under" @if ($slide->text_placement == 'under') {{ 'selected' }} @endif>Under Image</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Text Alignment</label>
                        <select class="form-control" name="text-alignment">
                            <option value="left" @if ($slide->text_alignment == 'left') {{ 'selected' }} @endif>Left</option>
                            <option value="right" @if ($slide->text_alignment == 'right') {{ 'selected' }} @endif>Right</option>
                            <option value="center" @if ($slide->text_alignment == 'center') {{ 'selected' }} @endif>Centered</option>
                            <option value="justify" @if ($slide->text_alignment == 'justify') {{ 'selected' }} @endif>Justified</option>
                        </select>
                    </div>

                </div>
            </div>
            <p>Add Up to 4 Choices:<br/>If no choice is selected the slide will advance with a single continue button.</p>
            <div class="row">
                <div class="col-xs-12">
                    @foreach ($slide->choices()->get() as $choice)
                        <div class="panel panel-default panel-no-body">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a href="/choice/{{ $choice->id }}/edit">Choice {{ $choice->order }} @if (!empty($choice->text) && $choice->text != 'This is where choice text goes.') {{ ' : '.$choice->text }} @endif</a>
                                    <div class="btn-group pull-right">
                                        <a href="javascript:deleteChoice('{{ $choice->id }}')" class="btn btn-panel-transparent"><i class="fa fa-times text-valign-center"></i></a>
                                    </div>
                                </h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if (count($slide->choices()->get()) < 4)
                <button type="button" class="btn btn-default btn-margin-bottom" data-toggle="modal" data-target="#add-choice-modal"><i class="fa fa-plus"></i> Add New Choice</button>
            @endif
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>
@stop

@section('footer-include')
    <script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
    <script>
        $(function(){
            // Initialize TinyMCE
            tinymce.init({
                selector: '.wysiwyg',
                elementpath: false,
                statusbar: false,
                menubar: false,
            });
        });

        // Submit for when clicking 'Save' button
        $( "#save-button" ).click(function(event) {
            event.preventDefault();
            $( "#slide-form" ).submit();
        });

        function deleteChoice(id) {
            if (confirm('Delete this choice?')) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "DELETE",
                    url: '/choice/' + id,
                    success: function(affectedRows) {
                        if (affectedRows > 0) location.reload();
                    }
                });
            }
        }
    </script>
@stop