@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                All Conference
            </div>
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
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
                    <tr>
                        <th scope="row">{{ $el->id }}</th>
                        <td class="list"><a href="{{ route('detail', $el->id) }}">{{ $el->name }}</a></td>
                        <td class="list"><a href="{{ route('detail', $el->id) }}">{{ $el->date }}</a></td>
                        <td>
{{--                            <a href="{{ route('edit_form') }}"><button class="btn btn-warning">Edit</button></a>--}}
                        </td>
                    </tr>
                </tbody>
                @endforeach
            </table>
            <div class="pagination">
                {{$data->links()}}
            </div>
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
