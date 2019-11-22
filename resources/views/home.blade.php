@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" id="app">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <quote></quote>
                </div>
            </div>
            <timer></timer>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ ucfirst(Auth::user()->name) }}</div>
                <log></log>
                <!-- {{ ucfirst(Auth::user()->name) }}
                <my-progress-bar></my-progress-bar> -->
                <!-- <div class="card-header">Activity Log: Your Last 5 Timers</div> -->

                <!-- <div class="card-body">

                </div> -->
            </div>
            <div class="card">
                <div class="card-header">Top Ten LeaderBoards</div>

                <div class="card-body">
                    <leader-boards></leader-boards>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
