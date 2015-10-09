@extends('framework')

@section('header-include')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="/css/bootstrap-colorpicker.min.css">
@stop

@section('navbar-right')
    <div id="navbar" class="navbar-collapse collapse">
        <div class="navbar-right">
            <a href="javascript:deleteIntroduction('{{ $introduction->id }}')" class="navbar-btn btn btn-sm btn-default" target="_blank">Delete</a>
            <a href="" class="navbar-btn btn btn-sm btn-primary" id="save-button">Save</a>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        @include('partials.input-errors')
        @include('flash::message')
        <p><a href="/story/{{ $introduction->story_id }}/edit"><i class="fa fa-angle-left"></i> Back to storyline</a></p>
        <form method="POST" action="/story/{{ $introduction->story->id }}/introduction" id="introduction-slide-form" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Introduction Message</label>
                        <textarea class="form-control wysiwyg" rows="3" name="message">{{ $introduction->message }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6">
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
                            <option value="left_top" @if ($introduction->background_placement == 'left_top') {{ 'selected' }} @endif>Left Top Align</option>
                            <option value="center_top" @if ($introduction->background_placement == 'center_top') {{ 'selected' }} @endif>Center Top Align</option>
                            <option value="tile" @if ($introduction->background_placement == 'tile') {{ 'selected' }} @endif>Tile</option>
                            <option value="fill" @if ($introduction->background_placement == 'fill') {{ 'selected' }} @endif>Fill</option>
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
            $( "#introduction-slide-form" ).submit();
        });

        function deleteIntroduction(id) {
            if (confirm('Delete this introduction slide?')) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "DELETE",
                    url: '/introduction/' + id,
                    success: function(affectedRows) {
                        if (affectedRows > 0) window.location.replace('/story/' + {{ $introduction->story->id }} + '/edit');
                    }
                });
            }
        }
    </script>
@stop