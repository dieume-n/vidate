@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Search for "{{ Request::get('q') }}"</div>
                <div class="card-body">
                    @if($channels->count())
                    <h4>Channels</h4>
                    <div class="card card-body">
                        @foreach ($channels as $channel)
                        <div class="media mb-2">
                            <div class="align-self-start mr-3">
                                @if($channel->image_file)
                                <img src="{{ $$channel->image_file }}" style="width: 40px; height: 40px"
                                    alt="{{ $channel->name }}" />
                                @else
                                {!! Avatar::create($channel->name)->setFontSize(20)->setDimension(40)->toSvg()
                                !!}
                                @endif
                            </div>
                            <div class="media-body">
                                <h5 class="mt-0 text-uppercase">
                                    <a href="{{ route('channels.show', $channel->slug) }}" class="media-heading">
                                        {{ $channel->name }}
                                    </a>
                                </h5>
                                Subscription count...

                            </div>
                        </div>
                        @endforeach

                    </div>
                    @endif

                    @if($videos->count())
                    @foreach ($videos as $video)
                    <div class="card card-body my-2">
                        <h4>Videos</h4>
                        @include('video.partials._video_result', [
                        'video' => $video
                        ])
                    </div>

                    @endforeach
                    @else
                    <p>No Video found...</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection