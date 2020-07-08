<?php

namespace App\Http\Controllers;

use App\Repositories\VideoRepository;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(VideoRepository $repository)
    {
        $videos = $repository->latestVideos();
        return view('welcome', [
            'videos' => $videos
        ]);
    }
}
