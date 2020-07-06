<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Video;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->q) {
            return redirect('/');
        }

        $channels = Channel::search($request->q)->take(2)->get();
        $videos = Video::search($request->q)->get();
        return view('search.index', [
            'channels' => $channels,
            'videos' => $videos
        ]);
    }
}
