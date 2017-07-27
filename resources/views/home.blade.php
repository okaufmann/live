@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <presence></presence>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <server-status></server-status>
            </div>
        </div>
    </div>
@endsection
