@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                My Conference
            </div>
            @foreach($data as $el)
                <div class="alert alert-success">
                    <h3>{{ $el->name }}</h3>
                </div>
            @endforeach
        </div>
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <a href="{{ url('/create') }}">+ New</a>
                @else
                    <a href="{{ route('login') }}">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
@endsection
