<div class="row no-gutters">
    <div class="col-sm-3 ">
        <a href="/videos/{{ $video->uid }}">
            <img src="{{ $video->getThumbnail() }}" alt="{{ $video->title }} thumbnail" class="img-fluid img-thumbnail" />
        </a>
    </div>
    <div class="col sm-10">
        <div class="d-flex flex-column">
            <h4 >
                <a href="{{ route('videos.show', $video->uid) }}">{{ $video->title }}</a>
            </h4>
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="{{ route('channels.show', $video->channel->slug) }}">{{ $video->channel->name }}</a>
                </li>
                <li class="list-inline-item">
                    {{ $video->viewCount() }} {{ Str::plural('view', $video->viewCount()) }}
                </li>
                <li class="list-inline-item">
                    {{ $video->created_at->diffForHumans() }}
                </li>
            </ul>
            @if($video->description)
            <p class="text-muted">{{ Str::limit($video->description, 120) }}</p>
            @endif
            
        </div>
    </div>
</div>