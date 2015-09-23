@extends('framework')

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
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Choice {{ $choice->order }}</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label>Choice Text</label>
                                            <input type="text" class="form-control" name="choice-text[]" value="{{ $choice->text }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-2">
                                        <div class="form-group">
                                            <label>Meter Effect</label>
                                            <select class="form-control" name="meter-effect[]">
                                                <option value="chance" @if ($choice->meter_type == 'chance') {{ 'selected' }} @endif>Probablility</option>
                                                <option value="specific" @if ($choice->meter_type == 'specific') {{ 'selected' }} @endif>Specific</option>
                                                <option value="none" @if ($choice->meter_type == 'none') {{ 'selected' }} @endif>None</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-10">
                                        <div class="form-group">
                                            <label>Choice Text</label>
                                            <input type="text" class="form-control" name="choice-text[]" value="{{ $choice->text }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if (count($slide->choices()->get()) < 4)
                        <a class="btn btn-default" href="/slide/{{ $slide->id }}/choice" role="button"><i class="fa fa-plus"></i> Add New Choice</a>
                    @endif
                </div>
            </div>
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
    </script>
@stop