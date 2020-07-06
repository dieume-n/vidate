<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;

class VideoVoteController extends Controller
{
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
