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
                Edit Conference
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

            <form action="{{route('edit_form_save', $data->id)}}" method="post">
                @csrf
                {{--Title--}}
                <div class="mb-3">
                    <label for="name" class="form-label">
                        Title
                        <input id="name" name="name" type="text" class="form-control" value="{{$data->name}}" placeholder="Conference title"/>
                    </label>
                </div>
                {{--Date--}}
                <div class="mb-3">
                    <label for="date" class="form-label">
                    Date
                    <input id="date" name="date" type="datetime-local" class="form-control" value="{{$data->date}}"/>
                    </label>
                </div>
                {{--Address--}}
                <div class="mb-3">
                    <label for="address" class="form-label">
                        Address
                        <input id="address" name="lat" type="number" class="form-control" placeholder="Lattitude" value="{{$data->lat}}"/>
                        <input id="address" name="lng" type="number" class="form-control" placeholder="Longitude" value="{{$data->lng}}"/>
                    </label>
                </div>
                {{--Country--}}
                <div class="mb-3">
                    <label for="countries" class="form-label">
                        Country
                        <select  name="countries" id="countries" class="form-control" style="width:200px;">
                            <option selected>{{$data->countries}}</option>
                        @foreach ($countries as $country)
                                <option value="{{$country->nicename}}">{{$country->nicename}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <button type="submit" class="btr btn-success">Save</button>
            </form>
        </div>
    </div>
@endsection
