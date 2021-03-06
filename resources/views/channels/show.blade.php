@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card ">
                <div class="card-body">
                    <div class="media">
                        <div class="align-self-start mr-3">
                            @if($channel->image_file)
                            <img src="{{ $channel->image_file }}" />
                            @else
                            {!! Avatar::create($channel->name)->setShape('square')->toSvg() !!}
                            @endif
                        </div>
                        <div class="media-body ml-3">
                            {{ ucwords($channel->name) }}

                            <ul class="list-inline">
                                <li>
                                    <subscribe-button channel-slug="{{ $channel->slug }}"></subscribe-button>
                                </li>
                                <li>
                                    {{ $channel->totalVideoViews() }}
                                    {{ Str::plural('view', $channel->totalVideoViews()) }}
                                </li>
                            </ul>

                            @if($channel->description)
                            <hr>

                            <p>{{ $channel->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">Videos</div>
                <div class="card-body">
                    @if($videos->count())
                    @foreach($videos as $video)
                    <div class="well">
                        @include('video.partials._video_result', ['video' => $video])
                    </div>
                    @endforeach

                    {{ $videos->links() }}
                    @else
                    <p>{{ $channel->name }} has no videos.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection