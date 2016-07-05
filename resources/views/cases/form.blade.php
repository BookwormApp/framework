@extends('layouts.app')

@section('content')
    <div class="page-header clearfix">
        <h1 class="page-title">{{ $case ? 'Edit Case' : 'Add Case' }}</h1>
        @if ( $case )
        <div class="page-actions">
            {!! Form::open(['method' => 'DELETE']) !!}
            {!! Form::hidden('case', $case->ref) !!}
            <button class="btn btn-link btn-danger" type="submit" data-confirm-delete="{{ $case->title }}">Delete Case</button>
            {!! Form::close() !!}
        </div>
        @endif
    </div>

    <div class="panel panel-default panel-form">
        {!! Form::open(['class' => 'form-horizontal']) !!}
        <div class="panel-body">
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title">Title</label>
                {!! Form::text('title', old('title', $case ? $case->title : ''), ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="panel-footer">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary">{{ $case ? 'Update' : 'Create' }}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@stop
