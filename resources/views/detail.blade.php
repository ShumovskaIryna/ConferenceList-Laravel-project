@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <a href="{{ route('conferences_all') }}">CONFERENCE LIST</a>
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
                Detail about "{{$data->name}}"
            </div>
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
                @csrf
                {{--Title--}}
                <div class="mb-3">
                    <label for="name" class="form-label">
                        Title
                        <input id="name" name="name" type="text" class="form-control" placeholder="Conference title" value="{{$data->name}}" disabled/>
                    </label>
                </div>
                {{--Date--}}
                <div class="mb-3">
                    <label for="date" class="form-label">
                        Date
                        <input id="date" name="date" type="datetime-local" class="form-control" value="{{$data->date}}" min="{{$data->date}}" max="{{$data->date}}"/>
                    </label>
                </div>
                {{--Address--}}
                <div class="mb-3">
                    <label for="address" class="form-label">
                        Address
                        <input id="address" name="lat" type="number" class="form-control" value="{{$data->lat}}" disabled/>
                        <input id="address" name="lng" type="number" class="form-control" value="{{$data->lng}}" disabled/>
                   </label>
                </div>
                {{--Country--}}
                <div class="mb-3">
                    <label for="countries" class="form-label">
                        Country
                        <select  name="countries" id="countries" class="form-control" style="width:200px;">
                            <option selected>{{$data->countries}}</option>
                        </select>
                    </label>
                </div>
            <a href="{{ route('edit_form', $data->id) }}">
                    <button class="btn btn-primary">Edit</button>
            </a>
            <a href="{{ route('conference_delete', $data->id) }}">
                <button class="btn btn-danger">Delete</button>
            </a>
        </div>
    </div>
@endsection
