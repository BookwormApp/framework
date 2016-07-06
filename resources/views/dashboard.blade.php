@extends('layouts.app')

@section('content')
	<div class="page-header clearfix">
        <h1 class="page-title">Active Projects</h1>
        <div class="page-actions">
            <a href="{{ url('settings/projects/create') }}" class="btn btn-default">New Project</a>
        </div>
    </div>

    <div class="row">
    	@foreach ( $projects as $project )
    	<div class="col-sm-3">
    		<div class="panel panel-project panel-project-active">
                <div class="panel-heading">
                    <h2 class="panel-title"><a href="{{ $project->url() }}">{{ $project->title }}</a></h2>
                </div>
                <div class="panel-footer">
                    Last Updated: {{ $project->created_at->format('d/m/y h:i A') }}</li>
                </div>
            </div>
    	</div>
		@endforeach
    </div>
</div>
@endsection
