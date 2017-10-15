@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <chat-client></chat-client>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <server-status></server-status>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <events></events>
            </div>
        </div>
    </div>
@endsection
