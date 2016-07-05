@extends('layouts.app')

@section('content')
    <div class="page-header clearfix">
        <h1 class="page-title">{{ $project ? 'Edit Project' : 'Add Project' }}</h1>
        @if ( $project )
        <div class="page-actions">
            {!! Form::open(['method' => 'DELETE']) !!}
            {!! Form::hidden('project', $project->ref) !!}
            <button class="btn btn-link btn-danger" type="submit" data-confirm-delete="{{ $project->title }}">Delete Project</button>
            {!! Form::close() !!}
        </div>
        @endif
    </div>

    <div class="panel panel-default panel-form">
        {!! Form::open(['class' => 'form-horizontal']) !!}
        <div class="panel-body">
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title">Title</label>
                {!! Form::text('title', old('title', $project ? $project->title : ''), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                <label for="slug">Slug</label>
                {!! Form::text('slug', old('slug', $project ? $project->slug : ''), ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="panel-footer">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary">{{ $project ? 'Update' : 'Create' }}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@stop
