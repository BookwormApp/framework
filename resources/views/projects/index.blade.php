@extends('layouts.app')

@section('content')
    <div class="page-header clearfix">
        <h1 class="page-title">Projects</h1>
        <div class="page-actions">
            <a href="{{ url('settings/projects/create') }}" class="btn btn-default">New Project</a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default panel-table">
                @if ($projects->isEmpty())
                    <div class="panel-body">
                        <div class="no-content">
                            <i class="fa fa-project-o fa-2x"></i>
                            @if (Input::except('page'))
                                <p>No projects match search</p>
                            @else
                                <p>No projects</p>
                                <a href="{{ url('settings/projects/create') }}" class="btn btn-default">New Project</a>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th width="100">#</th>
                                <th>Title</th>
                                <th width="100"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ( $projects as $project )
                                <tr data-href="{{ $project->editUrl() }}">
                                    <td>{{ $project->ref }}</td>
                                    <td>{{ $project->title }}</td>
                                    <td class="links">
                                        <a href="{{ $project->editUrl() }}" class="btn btn-default">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <div class="pagination-container">
                            {!! $projects->links() !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
