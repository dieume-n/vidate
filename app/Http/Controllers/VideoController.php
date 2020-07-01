<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;
use App\Http\Requests\VideoUpdateRequest;

class VideoController extends Controller
{

    public function index(Request $request)
    {
        $videos = $request->user()->videos()->latestFirst()->paginate(5);
        return view('video.index', compact('videos'));
    }

    public function edit(Video $video)
    {
        $this->authorize('edit', $video);

        return view('video.edit', compact('video'));
    }


    public function store(Request $request) 
    {
        $uid = uniqid(true);
        $channel = $request->user()->channel; 

        $video = $channel->videos()->create([
            'uid' => $uid,
            'title' => $request->title,
            'description' => $request->description,
            'visibility' => $request->visibility,
            'video_filename' => "{$uid}.{$request->extension}"
        ]);

        return response()->json([
            'data' =>[
                'uid' => $uid,
            ]
        ]);
    }

    public function update(VideoUpdateRequest $request, Video $video)
    {
        $this->authorize('update', $video);

        $video->update([
            'title'=> $request->title,
            'description' => $request->description,
            'visibility' => $request->visibility,
            'allow_votes' => $request->has('allow_votes'),
            'allow_comments' => $request->has('allow_comments')
        ]);

        if($request->ajax()){
            return response()->json([], 200);
        }

        return redirect()->back();
    }

    public function destroy(Video $video)
    {
        $this->authorize('delete', $video);
        $video->delete();
        return redirect()->back();
    }
}
