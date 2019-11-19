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

                    You are logged in!
                </div>
            </div>
            <timer></timer>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Your Activity Log</div>

                <div class="card-body">
                    <log></log>
                </div>
            </div>
            <div class="card">
                <div class="card-header">LeaderBoards</div>

                <div class="card-body">

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
