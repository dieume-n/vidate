@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 mx-auto">

            @if($video->isPrivate() && Auth::check() && $video->ownedByUser(Auth::user()))
                <div class="alert alert-info" role="alert">
                    Your video is currently private. Only you can see it.
                </div>
            @endif

            @if($video->isProcessed() && $video->canBeAccessed(Auth::user()))
                Show video player
            @endif

            @if(!$video->isProcessed())
                <div class="video-placeholder">
                    <div class="video-placeholder__header">
                        This video is processing. come back later.
                    </div>
                </div>
            @elseif(!$video->canBeAccessed(Auth::user()))
                <div class="video-placeholder">
                    <div class="video-placeholder__header">
                        This video is Private.
                    </div>
                </div>
            @endif
            
            <div class="card">
                <div class="card-body">
                    <h4>{{ $video->title }}</h4>
                    <div class="d-flex justify-content-between mb-2">
                        <div>video views</div>
                        <div>
                            likes
                        </div>
                    </div>
                    <div class="media">
                        <div class="align-self-start mr-3">
                            <a href="{{ route('channels.show', $video->channel->slug) }}">
                                @if($video->channel->image_file)
                                    <img src="{{ $video->$channel->image_file }}" style="width: 40px; height: 40px" alt="{{ $video->channel->slug }}" />
                                @else
                                    {!! Avatar::create($video->channel->name)->setFontSize(20)->setDimension(40)->toSvg() !!}
                                @endif
                            </a>
                        </div>
                        <div class="media-body">
                            <div class="mt-0 d-flex justify-content-between">
                                <h5 class="mt-2">
                                    <a href="{{ route('channels.show', $video->channel->slug) }}" class="media-heading">
                                        {{ $video->channel->name }}
                                    </a>
                                </h5>
                                <div>
                                    <button class="btn btn-danger" type="button">Subscribe</button>
                                </div>
                            </div>
                            
                            @if($video->description)
                                <div class="mt-3 video-description__line_height">
                                    {!!  nl2br(e($video->description)) !!}
                                </div>
                            @endif  
                        </div>
                    </div>
                </div>

                
            </div>
            @if($video->description)
                <div class="card">
                    <div class="card-body">
                        {!!  nl2br(e($video->description)) !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection