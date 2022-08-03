@extends('layout')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="float-left mb-2">
                    <h2>Add Event</h2>
                </div>
            </div>
        </div>
        @if(session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Event Name:</strong>
                        <input type="text" name="name" class="@error('name') is-invalid @enderror form-control" placeholder="Event Name">
                        @error('name')
                        <div class="invalid-feedback mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Slug:</strong>
                        <input type="text" name="slug" class="@error('slug') is-invalid @enderror form-control" placeholder="Slug">
                        @error('slug')
                        <div class="invalid-feedback mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Event Start Date:</strong>
                        <input type="text" name="start_at" class="@error('start_at') is-invalid @enderror form-control" placeholder="Event start date">
                        @error('start_at')
                        <div class="invalid-feedback mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Event End Date:</strong>
                        <input type="text" name="end_at" class="@error('end_at') is-invalid @enderror form-control" placeholder="Event end date">
                        @error('end_at')
                        <div class="invalid-feedback mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <a class="btn btn-secondary ml-3" href="{{ route('events.index') }}"> Back</a>
                <button type="submit" class="btn btn-primary ml-3">Add</button>
            </div>
        </form>
    </div>
@endsection
