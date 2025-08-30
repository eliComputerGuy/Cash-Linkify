<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commission extends Model
{
    use HasFactory;

    protected $casts = ['meta' => 'array'];
    protected $fillable = [
        'beneficiary_user_id',
        'source_user_id',
        'task_log_id',
        'video_id',
        'amount',
        'level',
        'type',
        'meta',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sourceUser()
    {
        return $this->belongsTo(User::class, 'source_user_id');
    }

    public function task()
    {
        return $this->belongsTo(UserVideoTask::class);
    }


    public function beneficiary() { return $this->belongsTo(User::class, 'beneficiary_user_id'); }
    // public function sourceUser()  { return $this->belongsTo(User::class, 'source_user_id'); }
    public function taskLog()     { return $this->belongsTo(TaskLog::class, 'task_log_id'); }
    public function video()       { return $this->belongsTo(Video::class, 'video_id'); }
}
