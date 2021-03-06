<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    use SoftDeletes ;
    protected $fillable = ['title', 'content', 'status', 'image' , 'views', 'user_id', 'category_id'];
    protected $attributes = [
        'status' => 1,
        'views' => 0,
    ];

    public function comments() {
        return $this->hasMany(App\Post::class);
    }
    public function likes() {
        return $this->hasMany(App\Post::class);
    }
}
