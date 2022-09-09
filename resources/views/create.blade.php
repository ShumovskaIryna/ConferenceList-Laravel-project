@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <a href="{{ url('/conferences') }}">CONFERENCE LIST</a>
                @else
                    <a href="{{ route('login') }}">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="content">
            <div class="title m-b-md">
                Create Conference
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{route('conferences')}}" method="post">
                @csrf
                {{--Title--}}
                <div class="mb-3">
                    <label for="name" class="form-label">
                        Title
                        <input id="name" name="name" type="text" class="form-control" placeholder="Conference title"/>
                    </label>
                </div>
                {{--Date--}}
                <div class="mb-3">
                    <label for="date" class="form-label">
                    Date
                    <input id="date" name="date" type="datetime-local"/>
                    </label>
                </div>
                {{--Address--}}

                <button type="submit" class="btr btn-success">Create</button>
            </form>
        </div>
    </div>
@endsection
