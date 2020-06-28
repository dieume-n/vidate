<?php

namespace App\Http\Controllers;

use JD\Cloudder\Facades\Cloudder;
use App\Channel;
use App\Jobs\UploadImage;
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

        if($request->file('image')){

            $path= $request->file('image')->storeAs('uploads', uniqid(true));

            $this->dispatch(new UploadImage($channel, $path, 'vidate/channels_images/'));
        }

        return redirect()->route('channels.edit', $channel->slug);

    }
}
