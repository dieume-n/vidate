@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Videos</div>

                <div class="card-body">
                    @if($videos->count())
                        @foreach($videos as $video)
                            <div class="card card-body mb-2">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <a href="/videos/{{ $video->uid }}">
                                            <img src="{{ $video->getThumbnail() }}" alt="{{ $video->title }} thumbnail" class="img-fluid img-thumbnail" />
                                       </a> 
                                    </div>
                                    <div class="col-sm-9">
                                        <a href="/videos/{{ $video->uid }}">{{ $video->title }}</a>
                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <p class="text-muted">
                                                    @if(!$video->isProcessed())
                                                        <p>Your video is being processed</p>
                                                    @else
                                                        <span>{{ $video->created_at->toDateTimeString() }}</span>
                                                    @endif
                                                </p>
                                                <form method="get">
                                                    <a href="{{ route('videos.edit',$video->uid) }}" class="btn btn-outline-info">Edit</a>
                                                </form>                                                
                                            </div>
                                            <div class="col-sm-6">
                                                <p>{{ ucfirst($video->visibility) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        @endforeach
                        <div class="mt-3">
                            {{ $videos->links() }}
                        </div>
                        
                    @else
                        <p>You have no videos</p>
                    @endif
                    <!-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif -->

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection