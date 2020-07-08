@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Latest videos</h4>
    @if ($videos->count())
    <div class="row">
        @foreach ($videos as $video)
        <div class="col-sm-3 mx-2">
            <div class="card pb-0" style="width: 18rem;">
                <img class="card-img-top" src="{{ $video->getThumbnail()}}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('videos.show', $video->uid) }}">{{ $video->title }}</a>
                    </h5>
                    <p class="card-text">
                        <a href="{{ route('channels.show', $video->channel->slug) }}">
                            {{ $video->channel->name }}
                        </a>
                    </p>
                    <ul class="list-inline">
                        <li class="list-inline-item card-text">
                            {{ $video->views->count() }} {{ Str::plural('view', $video->views->count())}}
                        </li>

                        <li class="list-inline-item card-text">
                            {{ $video->created_at->diffForHumans() }}
                        </li>
                    </ul>



                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif



</div>
@endsection