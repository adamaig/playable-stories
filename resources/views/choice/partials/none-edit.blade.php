<div class="container">
    <form method="POST" action="/choice/{{ $choice->id }}/edit" id="choice-edit-form">
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <label>Choice Text</label>
                    <input type="text" class="form-control" name="choice-text" value="{{ $choice->text }}" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2">
                <div class="form-group">
                    <label>Meter Effect</label>
                    <p>
                        <input class="form-control" type="text" name="choice-type" value="None" disabled>
                    </p>
                    </select>
                </div>
            </div>
            @foreach ($choice->outcomes()->get() as $key => $outcome)
                <div class="col-xs-10">
                    <div class="form-group">
                        <label>Vignette (optional)</label>
                        <textarea class="form-control wysiwyg" rows="3" name="vignette">{!! $outcome->vignette !!}</textarea>
                    </div>
                </div>
            @endforeach
        </div>
        {!! csrf_field() !!}
    </form>
</div>

