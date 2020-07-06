<?php

namespace App\Jobs;

use Storage;
use Illuminate\Bus\Queueable;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UploadVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path = storage_path() . '/app/uploads/' . $this->video->video_filename;

        \Cloudder::uploadVideo($path, null, [
            "folder" => "vidate/videos/",
            "eager" => [
                ["streaming_profile" => "full_hd", "format" => "m3u8"]
            ],
            "eager_async" => true,
        ]);
        $cloudinary_upload = Cloudder::getResult();
        if ($cloudinary_upload) {
            Storage::disk('local')->delete("uploads/{$this->video->video_filename}");
        }

        $this->video->video_public_id = $cloudinary_upload['public_id'];
        $this->video->video_url = $cloudinary_upload['eager'][0]['secure_url'];
        $this->video->processed = true;
        $this->video->save();
    }
}
