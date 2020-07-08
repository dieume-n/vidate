<?php

namespace App\Repositories;

use App\Video;

class VideoRepository
{
    public function latestVideos($limit = 10)
    {
        return Video::latestFirst()->visible()->take($limit)->get();
    }
}
