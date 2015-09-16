@extends('framework')

@section('header-include')
    <link rel="stylesheet" href="/css/bootstrap-colorpicker.min.css">
@stop

@section('navbar-right')
    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
            <li><a href="/story/{{ $story->id }}" class="btn btn-default" target="_blank">View</a></li>
            <li><a href="" class="btn btn-primary" id="save-button">Save</a></li>
        </ul>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                @include('partials.input-errors')
                @include('flash::message')
                <p class="pull-right">Public Link: <a href="/story/{{ $story->id }}" target="_blank">{{ getenv('APP_URL') }}/story/{{ $story->id }}</a></p>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#builder" aria-controls="builder" role="tab" data-toggle="tab">Builder</a></li>
                    <li role="presentation"><a href="#meters" aria-controls="meters" role="tab" data-toggle="tab">Meters</a></li>
                    <li role="presentation"><a href="#design" aria-controls="design" role="tab" data-toggle="tab">Design</a></li>
                </ul>

                <form method="POST" action="/story/{{ $story->id }}" id="story-builder-form" enctype="multipart/form-data">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="builder">

                            <div class="form-group">
                                <label for="story-name">Story Name</label>
                                <input type="text" class="form-control" id="story-name" placeholder="Story Name" value="{{ $story->name }}">
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Introduction Slide</h3>
                                </div>
                                <div class="panel-body">
                                    Panel content
                                </div>
                            </div>

                            @if (count($story->slides()->get()) == 0)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Slide 01</h3>
                                    </div>
                                    <div class="panel-body">
                                        Panel content
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div role="tabpanel" class="tab-pane" id="meters">
                            <div class="row">
                                <div class="col-xs-12">
                                    <p>Add Up to 2 Meters:<br/>Name your meter, select a meter type, and define the start, min, and max values. The start value is the value of the meter at the begining of the game. The min and max values will trigger messages defined below that will end the game. If there is no min or max value, leave the field blank.</p>
                                    @if (count($story->meters()->get()) == 0)
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Meter Name</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <label>Meter Name</label>
                                                            <input type="text" class="form-control" name="meter-name[]" placeholder="Cash" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <div class="form-group">
                                                            <label>Meter Type</label>
                                                            <select class="form-control" name="meter-type[]">
                                                                <option value="currency" selected>Currency</option>
                                                                <option value="percentage">Percentage</option>
                                                                <option value="number">Number</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <div class="form-group">
                                                            <label>Start Value</label>
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" name="meter-start-value[]" placeholder="1000" />
                                                                <div class="input-group-addon">$</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <div class="form-group">
                                                            <label>Min. Value</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="meter-min-value[]" placeholder="0" />
                                                                <div class="input-group-addon">$</div>
                                                            </div>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="meter-no-min[]" value="true"> No min.
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <div class="form-group">
                                                            <label>Max. Value</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="meter-max-value[]" placeholder="0" />
                                                                <div class="input-group-addon">$</div>
                                                            </div>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="meter-no-max[]" value="true" checked> No max.
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <label>Min. Value Header</label>
                                                            <input type="text" class="form-control" name="meter-min-value-header[]" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <label>Min. Value Text</label>
                                                            <textarea class="form-control wysiwyg" rows="3" name="meter-min-value-text[]"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <label>Max. Value Header</label>
                                                            <input type="text" class="form-control" name="meter-max-value-header[]" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <label>Max. Value Text</label>
                                                            <textarea class="form-control wysiwyg" rows="3" name="meter-max-value-text[]"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Meter Name</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <label>Meter Name</label>
                                                            <input type="text" class="form-control" name="meter-name[]" placeholder="Morality" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <div class="form-group">
                                                            <label>Meter Type</label>
                                                            <select class="form-control" name="meter-type[]">
                                                                <option value="currency">Currency</option>
                                                                <option value="percentage" selected>Percentage</option>
                                                                <option value="number">Number</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <div class="form-group">
                                                            <label>Start Value</label>
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" name="meter-start-value[]" placeholder="100" />
                                                                <div class="input-group-addon">%</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <div class="form-group">
                                                            <label>Min. Value</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="meter-min-value[]" placeholder="0" />
                                                                <div class="input-group-addon">%</div>
                                                            </div>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="meter-no-min[]" value="true"> No min.
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <div class="form-group">
                                                            <label>Max. Value</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="meter-max-value[]" placeholder="100" />
                                                                <div class="input-group-addon">#</div>
                                                            </div>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="meter-no-max[]" value="true"> No max.
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <label>Min. Value Header</label>
                                                            <input type="text" class="form-control" name="meter-min-value-header[]" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <label>Min. Value Text</label>
                                                            <textarea class="form-control wysiwyg" rows="3" name="meter-min-value-text[]"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <label>Max. Value Header</label>
                                                            <input type="text" class="form-control" name="meter-max-value-header[]" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <label>Max. Value Text</label>
                                                            <textarea class="form-control wysiwyg" rows="3" name="meter-max-value-text[]"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="design">
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label for="background-color">Background Color</label>
                                        <div class="input-group background-color">
                                            <span class="input-group-addon"><i></i></span>
                                            <input type="text" value="{{ $story->background_color }}" class="form-control" name="background-color" id="background-color" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="background-image">Background Image</label>
                                        <input type="file" name="background-image" id="background-image">
                                    </div>

                                    <div class="form-group">
                                        <label for="heading-font">Heading Font</label>
                                        <select class="form-control" name="heading-font" id="heading-font">
                                            @foreach ($fonts as $value=>$name)
                                                @if ($story->heading_font == $value)
                                                    <option value="{{ $value }}" selected>{{ $name }}</option>
                                                @else
                                                    <option value="{{ $value }}">{{ $name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="heading-font-size">Heading Font Size</label>
                                        <input type="number" class="form-control" name="heading-font-size" id="heading-font-size" value="{{ $story->heading_font_size }}" min="10" />
                                    </div>

                                    <div class="form-group">
                                        <label for="heading-font-color">Heading Font Color</label>
                                        <div class="input-group heading-font-color">
                                            <span class="input-group-addon"><i></i></span>
                                            <input type="text" value="{{ $story->heading_font_color }}" class="form-control" name="heading-font-color" id="heading-font-color" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="body-font">Body Font</label>
                                        <select class="form-control" name="body-font" id="body-font">
                                            @foreach ($fonts as $value=>$name)
                                                @if ($story->body_font == $value)
                                                    <option value="{{ $value }}" selected>{{ $name }}</option>
                                                @else
                                                    <option value="{{ $value }}">{{ $name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="body-font-size">Body Font Size</label>
                                        <input type="number" class="form-control" name="body-font-size" id="body-font-size" value="{{ $story->body_font_size }}" min="10" />
                                    </div>

                                    <div class="form-group">
                                        <label for="body-font-color">Body Font Color</label>
                                        <div class="input-group body-font-color">
                                            <span class="input-group-addon"><i></i></span>
                                            <input type="text" value="{{ $story->body_font_color }}" class="form-control" name="body-font-color" id="body-font-color" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="link-color">Link Color</label>
                                        <div class="input-group link-color">
                                            <span class="input-group-addon"><i></i></span>
                                            <input type="text" value="{{ $story->link_color }}" class="form-control" name="link-color" id="link-color" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="button-background-color">Button Color</label>
                                        <div class="input-group button-background-color">
                                            <span class="input-group-addon"><i></i></span>
                                            <input type="text" value="{{ $story->button_background_color }}" class="form-control" name="button-background-color" id="button-background-color" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="button-text-color">Button Text Color</label>
                                        <div class="input-group button-text-color">
                                            <span class="input-group-addon"><i></i></span>
                                            <input type="text" value="{{ $story->button_text_color }}" class="form-control" name="button-text-color" id="button-text-color" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
@stop

@section('footer-include')
    <script src="/js/bootstrap-colorpicker.min.js"></script>
    <script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
    <script>
        $(function(){
            // Initialize ColorPicker
            $('.background-color, .heading-font-color, .body-font-color, .link-color, .button-background-color, .button-text-color').colorpicker({
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
            $( "#story-builder-form" ).submit();
        });
    </script>
@stop