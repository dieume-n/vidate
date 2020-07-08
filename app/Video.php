<?php

namespace App;

use App\Traits\Orderable;
use Laravel\Scout\Searchable;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes, Searchable, Orderable;

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

    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('reply_id');
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

    public function isPublic()
    {
        return $this->visibility === 'public';
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

    public function upVotes()
    {
        return $this->votes()->where('type', 'up');
    }
    public function downVotes()
    {
        return $this->votes()->where('type', 'down');
    }

    public function voteFromUser(User $user)
    {
        return $this->votes()->where('user_id', $user->id);
    }

    public function scopeProcessed($query)
    {
        return $query->where('processed', true);
    }

    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

    public function scopeVisible($query)
    {
        return $query->processed()->public();
    }

    public function toSearchableArray()
    {
        $properties = $this->toArray();
        $properties['visible'] = $this->isProcessed() && $this->isPublic();

        return $properties;
    }
}
