<?php

namespace App;

use JD\Cloudder\Facades\Cloudder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'title',
        'uid',
        'description',
        'video_filename',
        'video_public_id',
        'processed',
        'visibility',
        'allow_votes',
        'allow_comments'
    ];


    public function getRouteKeyName()
    {
        return 'uid';
    }


    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function getThumbnail()
    {
        return \Cloudder::secureShow($this->video_public_id, ["effect"=>"preview", "resource_type"=>"video"]);
    }

    public function isProcessed()
    {
        return $this->processed === true;
    }

    public function votesAllowed()
    {
        return (bool) $this->allow_votes;
    }

    public function commentsAllowed()
    {
        return (bool) $this->allow_comments;
    }
}
