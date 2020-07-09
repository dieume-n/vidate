<?php

namespace App\Http\Controllers;

use App\Jobs\UploadVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoUploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('video.upload');
    }

    public function store(Request $request)
    {
        $this->validateVideo();
        $channel = $request->user()->channel;
        $video = $channel->videos()->where('uid', $request->uid)->firstOrFail();

        if ($request->file('video')) {
            $request->file('video')->storeAs('videos', $video->video_filename, ['disk' => 'uploads']);
            $this->dispatch(new UploadVideo($video));
        }

        return response()->json([], 200);
    }

    public function validateVideo()
    {
        return request()->validate([
            'video' => 'required',
            'uid' => 'required',
        ]);
    }
}
