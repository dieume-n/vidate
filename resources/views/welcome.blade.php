@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Latest videos</h4>
    @if ($videos->count())
    <div class="row">
        @foreach ($videos as $video)
        <div class="col-md-3 col-lg-3">
            <div class="img-thumbnail bg-white">
                <a href="{{ route('videos.show', $video->uid) }}">
                    <img src="{{ $video->getThumbnail()}}" alt="video thumbnail" class="w-100">
                </a>
                <div class="caption mt-2 px-2">
                    <p>
                        <a href="{{ route('videos.show', $video->uid) }}">{{ $video->title }}</a>
                    </p>
                    <p class="">
                        <a href="{{ route('channels.show', $video->channel->slug) }}">
                            {{ $video->channel->name }}
                        </a>
                    </p>
                    <p class="d-flex justify-content-between">
                        <span>
                            {{ $video->views->count() }} {{ Str::plural('view', $video->views->count())}}
                        </span>
                        <span>
                            {{ $video->created_at->diffForHumans() }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif



</div>
@endsection