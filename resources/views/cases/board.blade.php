@extends('layouts.app')

@section('content')
    <div class="page-header clearfix">
        <h1 class="page-title">Cases</h1>
        <div class="page-actions">
            <a href="{{ $currentProject->url('cases/create') }}" class="btn btn-default">New Case</a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-default panel-board">
                <div class="panel-heading">
                    <h3 class="panel-title">Inbox</h3>
                </div>
                <div class="list-group case-list">
                    @foreach ( $cases['open'] as $case )
                    <a href="{{ $currentProject->url($case) }}" class="list-group-item case-item">
                        <h4 class="list-group-item-heading case-title">{{ $case->title }}</h4>
                        <p class="list-group-item-text"></p>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="panel panel-default panel-board">
                <div class="panel-heading">
                    <h3 class="panel-title">In Progress</h3>
                </div>
                <div class="list-group case-list">
                    @foreach ( $cases['progress'] as $case )
                    <a href="{{ $currentProject->url($case) }}" class="list-group-item case-item">
                        <h4 class="list-group-item-heading case-title">{{ $case->title }}</h4>
                        <p class="list-group-item-text"></p>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="panel panel-default panel-board">
                <div class="panel-heading">
                    <h3 class="panel-title">Closed</h3>
                </div>
                <div class="list-group case-list">
                    @foreach ( $cases['closed'] as $case )
                    <a href="{{ $currentProject->url($case) }}" class="list-group-item case-item case-item-closed">
                        <h4 class="list-group-item-heading case-title">{{ $case->title }}</h4>
                        <p class="list-group-item-text"></p>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop
