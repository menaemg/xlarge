<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    use SoftDeletes ; 
    protected $fillable = ['title', 'content', 'status', 'image' , 'user_id', 'category_id'];
    protected $attributes = [
        'status' => true,
        'user_id' => 1,
        'category_id' => 1,
    ];

    public function comments() {
        return $this->hasMany(App\Post::class);
    }
}
