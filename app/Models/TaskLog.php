<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    protected $fillable = [
        'user_id',     // allow mass assignment
        'video_id',
        'earned',
        // add any other fields you save via ::create()
    ];


    public function user()  { return $this->belongsTo(User::class, 'user_id'); }
    public function video() { return $this->belongsTo(Video::class, 'video_id'); }
}
