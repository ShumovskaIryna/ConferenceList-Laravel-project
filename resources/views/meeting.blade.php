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
                        <th scope="col"> </th>
                        <th scope="col"> </th>
                    </tr>
                </thead>
                @foreach($data as $el)
                    <tr>
                        <th scope="row">{{ $el->id }}</th>
                        <td class="list" style="max-width:400px"><a href="{{ route('detail', $el->id) }}">{{ $el->name }}</a></td>
                        <td class="list"><a href="{{ route('detail', $el->id) }}">{{ $el->date }}</a></td>
                        <td>
                           <a href="{{ route('detail', $el->id) }}"><button class="btn btn-outline-info">Detail</button></a>
                        </td>
                        <td>
                            @if($el->isOwn)<button class="btn btn-outline-success">IT IS MINE</button>
                            @else <button class="btn btn-outline-success">Join</button>
                            @endif
                        </td>
                        <td>
                            <div class="hide">
                                <ul>
                                    <li class="button">{!! $contents=\Share::page(null, $el->content)->facebook(); !!}</li>
                                    <li class="button">{!! $contents=\Share::page(null, $el->content)->twitter(); !!}</li>
                                </ul>
                            </div>
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
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">+ New</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
@endsection
