<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;
    public $timestamps = false;
    protected $guarded = [];

    public function posts()
    {
        return $this->hasMany(Post::class,'category_id','id');
    }
}
