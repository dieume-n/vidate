<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;

class VideoViewController extends Controller
{
    public function store(Request $request, Video $video)
    {
        if (!$video->canBeAccessed($request->user())) {
            return;
        }

        $video->views()->create([
            'user_id' => $request->user() ? $request->user()->id : null,
            'ip_address' => $request->ip()
        ]);

        return response()->json([], 200);
    }
}
