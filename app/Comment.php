<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Comment extends Model
{
    use SoftDeletes ;
    protected $fillable = ['content' , 'user_id' , 'post_id'];

    public function replays() {
        return $this->hasMany(App\Comment::class);
    }
}
