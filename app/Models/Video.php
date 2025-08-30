<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['title','url','available_date']; // etc
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    public function tasks()
    {
        return $this->hasMany(UserVideoTask::class);
    }
}
