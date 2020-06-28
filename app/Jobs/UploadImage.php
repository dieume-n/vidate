<?php

namespace App\Jobs;

use Image;
use File;
use Illuminate\Support\Facades\Storage;
use App\Channel;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $channel;
    public $path;
    public $location;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Channel $channel, $path, $location)
    {
        $this->channel = $channel;
        $this->path = $path;
        $this->location = $location;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $filePath = storage_path().'/app/'.$this->path;

        $fileName= $filePath.'.png';


        $image = Image::make($filePath);
        $image->encode('png')->fit(150, 150, function($c){
            $c->upsize();
        });
        $image->save($fileName);  
        Storage::disk('local')->delete($this->path);


        \Cloudder::upload($fileName,null, ['folder' => $this->location]);
        $cloundary_upload = Cloudder::getResult();
        if ($cloundary_upload){
            Storage::disk('local')->delete($this->path);
            Storage::disk('local')->delete($this->path.'.png');
        }

        $this->channel->image_file = $cloundary_upload['secure_url'];
        $this->channel->save();
    }
}
