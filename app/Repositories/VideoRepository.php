<?php

namespace App\Repositories;

use App\Video;

class VideoRepository
{
    public function latestVideos($limit = 10)
    {
        // return Video::query()
        //     ->select('id', 'title', 'uid', 'created_at', 'channel_id')
        //     ->with('channel:id,name,slug')
        //     ->latestFirst()
        //     ->visible()
        //     ->simplePaginate();
        return Video::query()->with('channel:id,name,slug')->latestFirst()->visible()->simplePaginate();

        // return Video::latestFirst()->visible()->take($limit)->get();
        // return Video::latestFirst()->visible()->take($limit)->get();
    }
}
