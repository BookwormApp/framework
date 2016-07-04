@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h3 class="panel-title pull-left">
                    {{ $user ? 'Edit User' : 'Create User' }}
                </h3>
                @if ( $user && ! $me->is($user) )
                    @can('delete', App\Users\User::class)
                    {!! Form::open(['method' => 'DELETE', 'class' => 'pull-right']) !!}
                    <button class="btn btn-danger" type="submit" data-confirm-delete="{{ $user->name }}">Delete</button>
                    {!! Form::close() !!}
                    @endcan
                @endif
            </div>
            {!! Form::open() !!}
            <div class="panel-body">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name">Name</label>
                    {!! Form::text('name', old('name', $user ? $user->name : ''), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email">E-mail</label>
                    {!! Form::email('email', old('email', $user ? $user->email : ''), ['class' => 'form-control', 'placeholder' => 'User E-mail']) !!}
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password">Password</label>
                    @if ( $user )
                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'New Password']) !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm New Password']) !!}
                        <p class="help-block">Only enter a new password if you are changing from the current password. Otherwise, leave blank.</p>
                    @else
                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password']) !!}
                    @endif
                </div>
                <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                    <label for="role">Role</label>
                    {!! Form::select('role', select_placeholder($roles), old('role', $user ? $user->getRole()->name : ''), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group{{ $errors->has('centre') ? ' has-error' : '' }}">
                    <label class="control-label" for="centre">Care Home</label>
                    {!! Form::select('centre', select_placeholder($centres), old('centre', $user && $user->centre ? $user->centre->ref : ''), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="panel-footer">
                <button class="btn btn-primary" type="submit">{{ $user ? 'Update' : 'Create' }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop
