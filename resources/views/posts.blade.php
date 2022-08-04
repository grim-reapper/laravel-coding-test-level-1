@extends('layout')
@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">List of Posts <small>(Using jsonplaceholder api)</small></h2>
        @if($data)
            <div class="row">
            @foreach($data as $d)
                <div class="col-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ucfirst($d['title'])}}</h5>
                        <p class="card-text">{!! $d['body'] !!}</p>
                    </div>
                </div>
                </div>
            @endforeach
            </div>
        @endif
    </div>
@endsection
