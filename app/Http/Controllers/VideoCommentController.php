<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Video;
use Illuminate\Http\Request;

class VideoCommentController extends Controller
{
    public function index(Video $video)
    {
        $comments = $video->comments()->latestFirst()->get();
        return CommentResource::collection($comments);
    }
}
