@extends('layout')

@section('content')
    <div class="container mt-5">
        @if(isset($events))
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="float-left">
                        <h2>Events</h2>
                    </div>
                    <div class="float-right mb-2">
                        <a class="btn btn-success" href="{{ route('events.create') }}"> Create Event</a>
                    </div>
                </div>
            </div>
            <form action="{{route('events.index')}}" method="GET" role="search" class="mt-5 mb-5">
                <div class="input-group">
                    <input type="text" class="form-control" name="q"
                           placeholder="Search events"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
                </div>
            </form>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Start AT</th>
                    <th>End At</th>
                    <th>Created AT</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($events as $event)
                    <tr>
                        <td>{{$event->name}}</td>
                        <td>{{$event->slug}}</td>
                        <td>{{$event->start_at->format('Y-m-d')}}</td>
                        <td>{{$event->end_at->format('Y-m-d')}}</td>
                        <td>{{$event->created_at->format('Y-m-d')}}</td>
                        <td>
                            <form action="{{ route('events.destroy',$event->id) }}" method="Post">
                                <a class="btn btn-primary" href="{{ route('events.edit',$event->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            {!! $events->withQueryString()->links() !!}@endif
    </div>
@endsection
