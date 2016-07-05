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
    	<div class="col-sm-4">
    		<div class="panel panel-default panel-project">
                <a href="{{ $project->url() }}">
                    <div class="panel-heading">
                        <h2 class="panel-title">{{ $project->title }}</h2>
                    </div>
                    <div class="panel-body">
                    </div>
                </a>
                <div class="panel-footer">
                    <ul>
                        <li>Last Updated: {{ $project->created_at->format('d/m/y h:i A') }}</li>
                    </ul>
                </div>
            </div>
    	</div>
		@endforeach
    </div>
</div>
@endsection
