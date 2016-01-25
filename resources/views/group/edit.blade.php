@extends('framework')

@section('header-include')
    <link rel="stylesheet" href="/css/bootstrap-colorpicker.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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

        <form method="POST" action="/group/update/{{ $group->id }}" id="edit-group-form" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="name">Group Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php if(old('name')) { echo old('name'); } else { echo $group->name; } ?>" placeholder="Your story group name">
                    </div>
                </div>
            </div>

            <?php $counter = 0; ?>
            @foreach($selectedStories as $selectedStory => $buttonName)
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            @if($counter == 0)<label for="name">Select stories in this group</label>@endif
                            <select class="form-control" name="stories[]">
                                @foreach ($stories as $story)
                                    <option value="{{ $story->id }}" @if($story->id == $selectedStory) {{ 'selected' }} @endif>{{ $story->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            @if($counter == 0)<label for="name">Button name override</label>@endif
                            <input type="text" class="form-control" name="button-name[]" placeholder="Optional" value="{{ $buttonName }}">
                        </div>
                    </div>
                </div>
                <?php $counter++; ?>
            @endforeach

            <div class="row" id="add-above">
                <div class="col-xs-12">
                    <a class="btn btn-default btn-margin-bottom" href="#" role="button" id="add-story-to-group"><i class="fa fa-plus"></i> Add Story to Group</a>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Group Message</label>
                        <textarea class="form-control wysiwyg" rows="3" name="message">{{ $group->message }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label>Text Alignment</label>
                        <select class="form-control" name="text-alignment">
                            <option value="left" @if ($group->text_alignment == 'left') {{ 'selected' }} @endif>Left</option>
                            <option value="right" @if ($group->text_alignment == 'right') {{ 'selected' }} @endif>Right</option>
                            <option value="center" @if ($group->text_alignment == 'center') {{ 'selected' }} @endif>Centered</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="background-color">Background Color</label>
                        <div class="input-group background-color">
                            <span class="input-group-addon"><i></i></span>
                            <input type="text" value="{{ $group->background_color }}" class="form-control" name="background-color" id="background-color" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="photo">Photo @if ($group->photo)<a href="/group/{{ $group->id }}/remove/photo" title="Remove Photo"><i class="fa fa-trash-o"></i></a>@endif</label>
                        @if ($group->photo)
                            <p><img src="/img/group-photos/{{ $group->photo }}" alt="" class="img-thumbnail"></p>
                        @else
                            <input type="file" name="photo" id="photo">
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-3">
                    <div class="form-group">
                        <label>Photo Type</label>
                        <select class="form-control" name="photo-type">
                            <option value="above" @if ($group->photo_type == 'above') {{ 'selected' }} @endif>Above Message</option>
                            <option value="below" @if ($group->photo_type == 'below') {{ 'selected' }} @endif>Below Message</option>
                            <option value="background" @if ($group->photo_type == 'background') {{ 'selected' }} @endif>Background</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="form-group">
                        <label>Background Placement</label>
                        <select class="form-control" name="background-placement">
                            <option value="left_top" @if ($group->background_placement == 'left_top') {{ 'selected' }} @endif>Left Top Align</option>
                            <option value="center_top" @if ($group->background_placement == 'center_top') {{ 'selected' }} @endif>Center Top Align</option>
                            <option value="tile" @if ($group->background_placement == 'tile') {{ 'selected' }} @endif>Tile</option>
                            <option value="fill" @if ($group->background_placement == 'fill') {{ 'selected' }} @endif>Fill</option>
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
            $( "#edit-group-form" ).submit();
        });
    </script>
@stop