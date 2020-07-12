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
                        @method('patch')
                        <div class="form-group">
                            <label for=" name">Name</label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value=" {{ old('name') ? old('name') : $channel->name }}">

                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="slug">Unique URL</label>
                            <div class="alert alert-info" role="alert">
                                {{config('app.url'). '/channels/'. $channel->slug}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for=" description">Description</label>
                            <textarea name="description" id="description" cols="30" rows="5"
                                class="form-control @error('description') is-invalid @enderror">{{ old('description') ? old('description') : $channel->description }}</textarea>

                            @error('description')
                            <div class=" invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <p>Channel image</p>
                            <input type="file" name="image" id="image" class=" @error('image') is-invalid @enderror">

                            @error('image')
                            <div class=" invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary" type="submit">Update</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection