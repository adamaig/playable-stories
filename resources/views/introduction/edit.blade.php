@extends('framework')

@section('header-include')
    <link rel="stylesheet" href="/css/bootstrap-colorpicker.min.css">
@stop

@section('navbar-right')
    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
            <li><a href="" class="btn btn-default" target="_blank">Delete</a></li>
            <li><a href="" class="btn btn-primary" id="save-button">Save</a></li>
        </ul>
    </div>
@stop

@section('content')
    <div class="container">
        <form method="POST" action="/story/{{ $introduction->story->id }}/introduction" id="introduction-slide-form" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="heading">Header Text</label>
                        <input type="text" class="form-control" id="heading" name="heading" value="{{ $introduction->heading }}">
                    </div>

                    <div class="form-group">
                        <label>Introduction Message</label>
                        <textarea class="form-control wysiwyg" rows="3" name="message">{{ $introduction->message }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label>Text Alignment</label>
                        <select class="form-control" name="text-alignment">
                            <option value="left" @if ($introduction->text_alignment == 'left') {{ 'selected' }} @endif>Left</option>
                            <option value="right" @if ($introduction->text_alignment == 'right') {{ 'selected' }} @endif>Right</option>
                            <option value="center" @if ($introduction->text_alignment == 'center') {{ 'selected' }} @endif>Centered</option>
                            <option value="justify" @if ($introduction->text_alignment == 'justify') {{ 'selected' }} @endif>Justified</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="background-color">Background Color</label>
                        <div class="input-group background-color">
                            <span class="input-group-addon"><i></i></span>
                            <input type="text" value="{{ $introduction->background_color }}" class="form-control" name="background-color" id="background-color" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" name="photo" id="photo">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-3">
                    <div class="form-group">
                        <label>Photo Type</label>
                        <select class="form-control" name="photo-type">
                            <option value="above" @if ($introduction->photo_type == 'above') {{ 'selected' }} @endif>Above Message</option>
                            <option value="below" @if ($introduction->photo_type == 'below') {{ 'selected' }} @endif>Below Message</option>
                            <option value="background" @if ($introduction->photo_type == 'background') {{ 'selected' }} @endif>Background</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="form-group">
                        <label>Background Placement</label>
                        <select class="form-control" name="background-placement">
                            <option value="left_top" @if ($introduction->text_alignment == 'left_top') {{ 'selected' }} @endif>Left Top Align</option>
                            <option value="center_top" @if ($introduction->text_alignment == 'center_top') {{ 'selected' }} @endif>Center Top Align</option>
                            <option value="tile" @if ($introduction->text_alignment == 'tile') {{ 'selected' }} @endif>Tile</option>
                            <option value="fill" @if ($introduction->text_alignment == 'fill') {{ 'selected' }} @endif>Fill</option>
                        </select>
                    </div>
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>
@stop

@section('footer-include')
    <script src="/js/bootstrap-colorpicker.min.js"></script>
    <script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
    <script>
        $(function(){
            // Initialize ColorPicker
            $('.background-color').colorpicker({
                align: 'left',
            });

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
            $( "#introduction-slide-form" ).submit();
        });
    </script>
@stop