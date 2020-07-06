<?php

namespace App;

use Laravel\Scout\Searchable;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes, Searchable;

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
        return Cloudder::secureShow($this->video_public_id, ["effect" => "preview", "resource_type" => "video"]);
    }

    public function isProcessed()
    {
        return $this->processed == true;
    }

    public function votesAllowed()
    {
        return (bool) $this->allow_votes;
    }

    public function commentsAllowed()
    {
        return (bool) $this->allow_comments;
    }

    public function isPrivate()
    {
        return $this->visibility === 'private';
    }

    public function ownedByUser(User $user)
    {
        return $this->channel->user->id === $user->id;
    }

    public function canBeAccessed($user = null)
    {
        if (!$user && $this->isPrivate()) {
            return false;
        }

        if ($user && $this->isPrivate() && ($user->id !== $this->channel->user_id)) {
            return false;
        }

        return true;
    }

    public function views()
    {
        return $this->hasMany(VideoView::class);
    }

    public function viewCount()
    {
        return $this->views->count();
    }
}
