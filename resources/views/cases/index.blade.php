@extends('layouts.app')

@section('content')
    <div class="page-header clearfix">
        <h1 class="page-title">Cases</h1>
        <div class="page-actions">
            <a href="{{ url('cases/create') }}" class="btn btn-default">New Case</a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default panel-table">
                @if ($cases->isEmpty())
                    <div class="panel-body">
                        <div class="no-content">
                            <i class="fa fa-case-o fa-2x"></i>
                            @if (Input::except('page'))
                                <p>No cases match search</p>
                            @else
                                <p>No cases</p>
                                <a href="{{ url('cases/create') }}" class="btn btn-default">New Case</a>
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
                            @foreach ( $cases as $case )
                                <tr data-href="{{ $case->url() }}">
                                    <td>{{ $case->ref }}</td>
                                    <td>{{ $case->title }}</td>
                                    <td class="links">
                                        <a href="{{ $case->url() }}" class="btn btn-default">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <div class="pagination-container">
                            {!! $cases->links() !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
