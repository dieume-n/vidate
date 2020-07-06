<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VideoViewController extends Controller
{
    const BUFFER = 30;

    public function store(Request $request, Video $video)
    {
        if (!$video->canBeAccessed($request->user())) {
            return;
        }

        // Grab last view from user
        if ($request->user()) {
            $lastUserView = $video->views()->latestbyUser($request->user())->first();

            if ($this->withinBuffer($lastUserView)) {
                return;
            }
        }

        // Grab last view by Ip address
        $latestIpView = $video->views()->latestByIp($request->ip())->first();

        if ($this->withinBuffer($latestIpView)) {
            return;
        }

        $video->views()->create([
            'user_id' => $request->user() ? $request->user()->id : null,
            'ip_address' => $request->ip()
        ]);

        return response()->json([], 200);
    }

    protected function withinBuffer($view)
    {
        return $view && $view->created_at->diffInSeconds(Carbon::now()) < self::BUFFER;
    }
}
