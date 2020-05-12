<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $attributes = [
        'status' => true,
    ];

    public function comments() {
        return $this->hasMany(App\Post::class);
    }
}
