@extends('layouts.app')

@section('content')
    <div class="page-header clearfix">
        <h1 class="page-title">Case #{{ $case->ref }}</h1>
        <div class="page-actions">
            {!! Form::open(['url' => $currentProject->url($case, 'actions')]) !!}
            <button class="btn btn-close" name="action" value="close" type="submit">Close case</button>
            <a href="{{ $currentProject->url($case, 'edit') }}" class="btn btn-default">Edit</a>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="panel panel-default panel-case">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $case->title }}</h3>
        </div>
        <div class="panel-body">
            {!! $case->description !!}
        </div>
    </div>

    <div class="panel panel-default panel-form">
        {!! Form::open(['class' => 'form-horizontal']) !!}
        <div class="panel-body">
            <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                <label for="comment">Comment</label>
                {!! Form::textarea('comment', old('comment'), ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="panel-footer">
            <button type="submit" name="action" value="comment" class="btn btn-primary">Comment</button>
            <button type="submit" name="action" value="close" class="btn btn-close">Close case</button>
        </div>
        {!! Form::close() !!}
    </div>

@stop
