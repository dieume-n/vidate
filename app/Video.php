<?php

namespace App;

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
}
