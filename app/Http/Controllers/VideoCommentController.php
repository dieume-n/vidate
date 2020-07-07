<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Video;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use App\Http\Requests\CreateVideoCommentRequest;

class VideoCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }

    public function index(Video $video)
    {
        $comments = $video->comments()->latestFirst()->get();
        return CommentResource::collection($comments);
    }

    public function create(CreateVideoCommentRequest $request, Video $video)
    {
        $this->authorize('comment', $video);

        $comment = $video->comments()->create([
            'body' => $request->body,
            'user_id' => $request->user()->id,
            'reply_id' => $request->get('reply_id', null)
        ]);

        return new CommentResource($comment);
    }

    public function delete(Video $video, Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return response()->json(null, 200);
    }
}
