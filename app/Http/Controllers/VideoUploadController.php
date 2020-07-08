<?php

namespace App\Http\Controllers;

use Storage;
use App\Jobs\UploadVideo;
use Illuminate\Http\Request;

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

            $request->file('video')->storeAs('uploads', $video->video_filename);

            $this->dispatch(new UploadVideo($video));
        }

        return response()->json([], 200);
    }

    public function validateVideo()
    {
        return request()->validate([
            'video' => 'required|mimetype:video',
            'uid' => 'required',
        ]);
    }
}
