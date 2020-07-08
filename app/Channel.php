<?php

namespace App;

use Laravolt\Avatar\Avatar;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Channel extends Model
{
    use Sluggable, Searchable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_filename'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function getImage()
    {
        return $this->image_file ? $this->image_file : null;
    }
    public function getLinkAttribute()
    {
        return asset("channels/$this->slug");
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function subscriptionCount()
    {
        return $this->subscriptions->count();
    }
}
