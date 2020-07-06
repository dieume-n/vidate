<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoView extends Model
{

    public $fillable = [
        'user_id',
        'ip_address'
    ];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
