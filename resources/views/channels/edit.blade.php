@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">Channel Settings</div>

                    <div class="card-body">

                        <form action="{{ route('channels.update', $channel) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-group {{ $errors->has('name') ? 'is-invalid' : ''}}">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') ? old('name') : $channel->name }}">

                                @if ($errors->has('name'))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="slug">Unique URL</label>
                                <h3><span class="badge badge-dark">{{config('app.url'). '/channels/'. $channel->slug}}</span></h3>
                            </div>

                            <div class="form-group {{ $errors->has('description') ? 'is-invalid' : ''}}">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description') ? old('description') : $channel->description }}</textarea>

                                @if ($errors->has('description'))
                                    <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <p>Channel image</p>
                                <div class="custom-file">
                                    <input type="file" name="image" id="image" class="custom-file-input">
                                    <label class="custom-file-label" for="image">Choose file...</label>
                                </div>
                            </div>

                            <button class="btn btn-primary" type="submit">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection