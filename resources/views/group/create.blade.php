@extends('framework')

@section('header-include')
    <link rel="stylesheet" href="/css/bootstrap-colorpicker.min.css">
@stop

@section('navbar-right')
    <div id="navbar" class="navbar-collapse collapse">
        <div class="navbar-right">
            <a href="" class="navbar-btn btn btn-sm btn-primary" id="save-button">Save</a>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                @include('partials.input-errors')
                @include('flash::message')
                <p><a href="/"><i class="fa fa-angle-left"></i> Back to story list</a></p>
            </div>
        </div>

        <form method="POST" action="/group/create" id="create-group-form" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="name">Group Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php if(old('name')) { echo old('name'); } else { echo 'Your story group name'; } ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="name">Select stories in this group</label>
                        <select class="form-control" name="stories[]">
                            @foreach ($stories as $story)
                                <option value="{{ $story->id }}">{{ $story->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="name">Button name override</label>
                        <input type="text" class="form-control" name="button-name[]" placeholder="Optional">
                    </div>
                </div>
            </div>
            <div class="row" id="add-above">
                <div class="col-xs-12">
                    <a class="btn btn-default btn-margin-bottom" href="#" role="button" id="add-story-to-group"><i class="fa fa-plus"></i> Add Story to Group</a>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Group Message</label>
                        <textarea class="form-control wysiwyg" rows="3" name="message">An introduction to your story group</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label>Text Alignment</label>
                        <select class="form-control" name="text-alignment">
                            <option value="left">Left</option>
                            <option value="right">Right</option>
                            <option value="center">Centered</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="background-color">Background Color</label>
                        <div class="input-group background-color">
                            <span class="input-group-addon"><i></i></span>
                            <input type="text" class="form-control" value="#FFFFFF" name="background-color" id="background-color" />
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
                            <option value="above">Above Message</option>
                            <option value="below">Below Message</option>
                            <option value="background">Background</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="form-group">
                        <label>Background Placement</label>
                        <select class="form-control" name="background-placement">
                            <option value="left_top">Left Top Align</option>
                            <option value="center_top">Center Top Align</option>
                            <option value="tile">Tile</option>
                            <option value="fill">Fill</option>
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
                format: 'hex',
            });

            // Initialize TinyMCE
            tinymce.init({
                selector: '.wysiwyg',
                elementpath: false,
                statusbar: false,
                menubar: false,
                plugins: [
                    "link", "autoresize",
                ],
                toolbar: 'formatselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link',
                fontsize_formats: "8pt 10pt 12pt 14pt 16pt 18pt 21pt 24pt 32pt 36pt",
            });
        });

        // Submit for when clicking 'Save' button
        $( "#save-button" ).click(function(event) {
            event.preventDefault();
            $( "#create-group-form" ).submit();
        });

        $( "#add-story-to-group" ).click(function(event) {
            event.preventDefault();
            $( "#add-above" ).before( '<div class="row"><div class="col-xs-6"><div class="form-group"><select class="form-control" name="stories[]">@foreach ($stories as $story)<option value="{{ $story->id }}">{{ $story->name }}</option>@endforeach</select></div></div><div class="col-xs-6"><div class="form-group"><input type="text" class="form-control" name="button-name[]" placeholder="Optional"></div></div></div>' );
            return false;
        });
    </script>
@stop