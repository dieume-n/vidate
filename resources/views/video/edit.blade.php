@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Video "{{ $video->title }}"</div>

                <div class="card-body">
                   <form action="{{ route('videos.update', $video->uid)}}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ? old('title') :$video->title }}">
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" cols="30" rows="5" >{{ old('description') ? old('description') :$video->description }}</textarea> 
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="visibility">Visibility</label>
                            <select class="custom-select" id="visibility" name="visibility">
                                @foreach(['public', 'private', 'unlisted'] as $visibility)
                                    <option value="{{ $visibility}}" {{ $video->visibility == $visibility ? 'selected="selected"' : '' }}>{{ ucfirst($visibility) }}</option>
                                @endforeach
                            </select>
                            @error('visibility')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" name="allow_votes" type="checkbox" id="allow_votes" {{ $video->votesAllowed() ? 'checked="checked"' : '' }}>
                                <label class="custom-control-label" for="allow_votes">
                                    Allow Votes
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" name="allow_comments" type="checkbox"  id="allow_comments" {{ $video->commentsAllowed() ? 'checked="checked"' : '' }} >
                                <label class="custom-control-label" for="allow_comments">
                                    Allow Comments
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection