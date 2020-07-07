<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVoteRequest;
use App\Video;
use Illuminate\Http\Request;

class VideoVoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function create(CreateVoteRequest $request, Video $video)
    {
        $this->authorize('vote', $video);

        // Delete current user vote of a specific video
        $video->voteFromUser($request->user())->delete();

        $video->votes()->create([
            'type' => $request->type,
            'user_id' => $request->user()->id
        ]);

        return response()->json([], 200);
    }


    public function remove(Request $request, Video $video)
    {
        $this->authorize('vote', $video);

        $video->voteFromUser($request->user())->delete();

        return response()->json([], 200);
    }


    public function show(Request $request, Video $video)
    {
        // Check if votes are allowed

        $reponse = [
            'up' => null,
            'down' => null,
            'can_vote' => $video->votesAllowed(),
            'user_vote' => null
        ];

        if ($video->votesAllowed()) {
            $reponse['up'] = $video->upVotes()->count();
            $reponse['down'] = $video->downVotes()->count();
        }

        if ($request->user()) {
            $voteFromUser = $video->voteFromUser($request->user())->first();
            $reponse['user_vote'] =  $voteFromUser ? $voteFromUser->type : null;
        }

        return response()->json([
            'data' => $reponse
        ], 200);
    }
}
