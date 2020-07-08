@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Latest videos from your subscriptions</div>

                <div class="card-body">
                    @if ($subscriptionVideos->count())
                    @foreach ($subscriptionVideos as $video)
                    @include('video.partials._video_result', [
                    'video' => $video
                    ])

                    @endforeach

                    @endif
                    {{-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                </div>
                @endif --}}


            </div>
        </div>
    </div>
</div>
</div>
@endsection