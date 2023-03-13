@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Greetings</div>

                <div class="panel-body">
                    Hello there, welcome to xE-wallet's.<br>
                </div>
                <div class="panel-body">
                    <a  class="btn btn-primary btn-sm" href="{{ url('/login') }}">Login</a>
                    <a  class="btn btn-default btn-sm" href="{{ url('/register') }}">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
