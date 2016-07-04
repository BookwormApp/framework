@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h3 class="panel-title pull-left">Users</h3>
                <div class="pull-right">
                    <a href="#search" data-toggle="collapse" class="btn btn-default">
                        <i class="fa fa-sliders"></i>
                    </a>
                    @can('create', App\Users\User::class)
                    <a href="{{ url('users/create') }}" class="btn btn-default">Create User</a>
                    @endcan
                </div>
            </div>
            <div class="collapse panel-body{{ Input::except('page') ? ' in' : '' }}" id="search">
                @include('users.partials.search_form')
            </div>
            @if ($users->isEmpty())
                <div class="panel-body">
                    <div class="no-content">
                        @if ( Input::except('page') )
                            <p>No users match that search</p>
                        @else
                            <p>No users</p>
                        @endif
                    </div>
                </div>
            @else
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Care Home</th>
                        <th width="30"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ( $users as $user )
                        <tr data-href="{{ $user->url() }}">
                            <td>{{ $user->ref }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->getRole() ? $user->getRole()->label : '' }}</td>
                            <td>{{ $user->centre ? $user->centre->title : '' }}</td>
                            <td class="links">
                                <a href="{{ $user->url() }}" class="btn">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="panel-footer">
                    {!! $users->links() !!}
                </div>
            @endif
        </div>
    </div>
@stop
