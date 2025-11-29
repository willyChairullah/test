<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $guarded = ['id'];

    public function members()
    {
        return $this->belongsToMany(User::class, 'member_classes', 'classroom_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'classroom_id', 'id');
    }
}
