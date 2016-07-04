@extends('layouts.app')

@section('content')
    <div class="page-header clearfix">
        <h1 class="page-title">{{ $user ? 'Edit User' : 'Add User' }}</h1>
        @if ( $user )
        <div class="page-actions">
            {!! Form::open(['method' => 'DELETE']) !!}
            {!! Form::hidden('user', $user->ref) !!}
            <button class="btn btn-link btn-danger" type="submit" data-confirm-delete="{{ $user->title }}">Delete User</button>
            {!! Form::close() !!}
        </div>
        @endif
    </div>

    <div class="panel panel-default panel-form">
        {!! Form::open(['class' => 'form-horizontal']) !!}
        <div class="panel-body">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name">Name</label>
                {!! Form::text('name', old('name', $user ? $user->name : ''), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email">E-mail</label>
                {!! Form::email('email', old('email', $user ? $user->email : ''), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password">Password</label>
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password']) !!}
            </div>
        </div>
        <div class="panel-footer">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary">{{ $user ? 'Update' : 'Create' }}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@stop
