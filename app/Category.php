<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{

    use SoftDeletes ;
    protected $fillable = ['name', 'description', 'subfrom'];
    protected $attributes = [
        'subfrom' => null,
        'description' => null,
    ];
}
