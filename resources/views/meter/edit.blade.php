@extends('framework')

@section('header-include')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('navbar-right')
    <div id="navbar" class="navbar-collapse collapse">
        <div class="navbar-right">
            <a href="javascript:deleteMeter('{{ $meter->id }}')" class="navbar-btn btn btn-default" target="_blank">Delete</a>
            <a href="" class="navbar-btn btn btn-primary" id="save-button">Save</a>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <form method="POST" action="/meter/{{ $meter->id }}" id="meter-form" enctype="multipart/form-data">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $meter->name }}</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Meter Name</label>
                                <input type="text" class="form-control" name="meter-name" value="{{ $meter->name }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>Meter Type</label>
                                <select class="form-control" name="meter-type">
                                    <option value="currency" @if ($meter->type == 'currency') {{ 'selected' }} @endif>Currency</option>
                                    <option value="percentage" @if ($meter->type == 'percentage') {{ 'selected' }} @endif>Percentage</option>
                                    <option value="number" @if ($meter->type == 'number') {{ 'selected' }} @endif>Number</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>Start Value</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="meter-start-value" value="{{ $meter->start_value }}" />
                                    <div class="input-group-addon">$</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>Min. Value</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="meter-min-value" value="{{ $meter->min_value }}" />
                                    <div class="input-group-addon">$</div>
                                </div>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="meter-no-min" value="true" @if (is_null($meter->min_value)) {{ 'checked' }} @endif> No min.
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>Max. Value</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="meter-max-value" value="{{ $meter->max_value }}" />
                                    <div class="input-group-addon">$</div>
                                </div>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="meter-no-max" value="true" @if (is_null($meter->max_value)) {{ 'checked' }} @endif> No max.
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Min. Value Header</label>
                                <input type="text" class="form-control" name="meter-min-value-header" value="{{ $meter->min_value_header }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Min. Value Text</label>
                                <textarea class="form-control wysiwyg" rows="3" name="meter-min-value-text">{!! $meter->min_value_text !!}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Max. Value Header</label>
                                <input type="text" class="form-control" name="meter-max-value-header" value="{{ $meter->max_value_header }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Max. Value Text</label>
                                <textarea class="form-control wysiwyg" rows="3" name="meter-max-value-text">{!! $meter->max_value_text !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! csrf_field() !!}
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
            $( "#meter-form" ).submit();
        });

        function deleteMeter(id) {
            if (confirm('Delete this meter?')) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "DELETE",
                    url: '/meter/' + id,
                    success: function(affectedRows) {
                        if (affectedRows > 0) window.location.replace('/story/' + {{ $meter->story->id }} + '/edit#tab_meters');
                    }
                });
            }
        }
    </script>
@stop