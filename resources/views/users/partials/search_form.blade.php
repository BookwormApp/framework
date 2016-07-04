{!! Form::open(['method' => 'GET', 'class' => 'well']) !!}
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="q">Keywords</label>
            {!! Form::text('q', Input::get('q'), ['class' => 'form-control', 'placeholder' => 'Search query...']) !!}
        </div>
    </div>
    <div class="col-sm-6">

    </div>
</div>
<hr />
<div class="row">
    @if ( Input::except('page') )
        <div class="col-sm-3">
            <a href="{{ url('patients') }}" class="btn btn-default">Reset</a>
        </div>
    @endif
    <div class="col-sm-4 pull-right">
        <button type="submit" class="btn btn-primary btn-block">Search</button>
    </div>
</div>
{!! Form::close() !!}
