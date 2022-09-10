@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                My Conference
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Date</th>
                        <th scope="col"> </th>
                    </tr>
                </thead>
                @foreach($data as $el)
                <tbody>
                    <tr>
                        <th scope="row">{{ $el->id }}</th>
                        <td>{{ $el->name }}</td>
                        <td>{{ $el->date }}</td>
                        <td>Edit</td>
                    </tr>
                </tbody>
                @endforeach
            </table>
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
