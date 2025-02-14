<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = ['user', 'follower_id', 'following_id'];
    public $timestamps = true;

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
