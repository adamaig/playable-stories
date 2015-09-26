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
                        <input class="form-control" type="text" name="choice-type" value="Probablility" disabled>
                    </p>
                    </select>
                </div>
            </div>
            <div class="col-xs-4">
                <label>Meter Name</label>
                @foreach ($meters as $key => $meter)
                    <div class="form-group">
                        <input class="form-control" type="text" name="meter-{{ $key+1 }}" value="{{ $meter->name }}" disabled>
                    </div>
                @endforeach
            </div>
            @foreach ($choice->outcomes()->get() as $key => $outcome)
                <div class="col-xs-2">
                    <div class="form-group">
                        <label>Outcome {{ $key+1 }} (+ or -)</label>
                        @foreach ($outcome->results()->get() as $resultKey => $result)
                            <div class="input-group">
                                <input type="number" class="form-control" name="meter-{{ $resultKey+1 }}-outcome-{{ $key+1 }}" value="{{ $result->change }}" />
                                <div class="input-group-addon">
                                    @if ($meters[$resultKey]['type'] == 'currency') 
                                        {{ '$' }}
                                    @elseif ($meters[$resultKey]['type'] == 'number')
                                        {{ '#' }}
                                    @elseif ($meters[$resultKey]['type'] == 'percentage')
                                        {{ '%' }}
                                    @endif
                                </div>
                            </div>
                            <!-- End for group and start a new one --></div><div class="form-group">
                        @endforeach
                        <label>Likelihood</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="likelihood-{{ $key+1 }}" value="{{ $outcome->likelihood }}" />
                            <div class="input-group-addon">%</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @foreach ($choice->outcomes()->get() as $key => $outcome)
            <div class="row">
                <div class="col-xs-10 col-xs-offset-2">
                    <div class="form-group">
                        <label>Vignette {{ $key+1 }} (optional)</label>
                        <textarea class="form-control wysiwyg" rows="3" name="vignette-{{ $key+1 }}">{!! $outcome->vignette !!}</textarea>
                    </div>
                </div>
            </div>
        @endforeach
        {!! csrf_field() !!}
    </form>
</div>

