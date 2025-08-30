<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserVideoTask extends Model
{
    use HasFactory;

    protected $table = 'user_video_tasks';
    protected $fillable = ['user_id','video_id','date_assigned','earnings','status'];
    protected $casts = [
        'user_id'  => 'integer',
        'video_id' => 'integer',
        'earnings' => 'float',
    ];


    public function video(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Video::class, 'video_id', 'id');
    }
}
