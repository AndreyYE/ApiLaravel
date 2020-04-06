<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
   protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function favorites()
    {
        return $this->hasMany(Favor::class,'posts_id','id');
    }
}
