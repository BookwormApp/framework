@extends('layouts.app')

@section('content')
    <div class="page-header clearfix">
        <h1 class="page-title">Users</h1>
        <div class="page-actions">
            <a href="{{ url('settings/users/create') }}" class="btn btn-default">New User</a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default panel-table">
                @if ($users->isEmpty())
                    <div class="panel-body">
                        <div class="no-content">
                            <i class="fa fa-user-o fa-2x"></i>
                            @if (Input::except('page'))
                                <p>No users match search</p>
                            @else
                                <p>No users</p>
                                <a href="{{ url('settings/users/create') }}" class="btn btn-default">New User</a>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th width="100"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ( $users as $user )
                                <tr data-href="{{ $user->url() }}">
                                    <td>{{ $user->ref }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="links">
                                        <a href="{{ $user->url() }}" class="btn btn-default">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <div class="pagination-container">
                            {!! $users->links() !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
