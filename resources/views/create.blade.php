@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <a href="{{ route('conferences_all') }}">BACK -></a>
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

            <form action="{{route('conferences_all')}}" method="post">
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
                    <input id="date" name="date" type="datetime-local" class="form-control"/>
                    </label>
                </div>
                {{--Address--}}
                <div class="mb-3">
                    <label for="address" class="form-label">
                        Address
                        <input id="lat" name="lat" type="number" class="form-control" placeholder="Lattitude"/>
                        <input id="lng" name="lng" type="number" class="form-control" placeholder="Longitude"/>
                        <div class="mt-3">
                            <div id="map" style="width: 300px; height: 300px;"></div>
                            <script>
                                let map;
                                function initMap() {
                                    map = new google.maps.Map(document.getElementById("map"), {
                                        center: { lat: 0, lng: 0 },
                                        zoom: 8,
                                        scrollwheel: true,
                                    });
                                    const uluru = { lat: 0, lng: 0 };
                                    let marker = new google.maps.Marker({
                                        position: uluru,
                                        map: map,
                                        draggable: true
                                    });
                                    google.maps.event.addListener(marker,'position_changed',
                                        function (){
                                            let lat = marker.position.lat()
                                            let lng = marker.position.lng()
                                            $('#lat').val(lat)
                                            $('#lng').val(lng)
                                        })
                                    google.maps.event.addListener(map,'click',
                                        function (event){
                                            pos = event.latLng
                                            marker.setPosition(pos)
                                        })
                                }
                            </script>
                            <script async defer src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap"
                                    type="text/javascript"></script>
                        </div>
                    </label>
                </div>
                {{--Country--}}
                <div class="mb-3">
                    <label for="countries" class="form-label">
                        Country
                        <select  name="countries" id="countries" class="form-control" style="width:200px;">
                            <option value="" selected disabled>Select Country</option>
                            @foreach ($countries as $country)
                                <option value="{{$country->nicename}}">{{$country->nicename}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <button type="submit" class="btn btn-success">Create</button>
            </form>
        </div>
    </div>
@endsection
