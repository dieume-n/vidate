<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Http\Requests\ChannelUpdateRequest;

class ChannelController extends Controller
{
    public function show(Channel $channel)
    {
        return view('channels.show', compact('channel'));
    }

    public function edit(Channel $channel)
    {
        $this->authorize('view', $channel);
        return view('channels.edit', compact('channel'));
    }


    public function update(ChannelUpdateRequest $request, Channel $channel)
    {
        $this->authorize('update', $channel);
        
        
        $channel->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('channels.edit', $channel->slug);

    }
}
