<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    // protected $fillable = [
    //     'user_id','category_id','title','content','image'
    // ];
    protected $fillable = [
        'user_id','title','content','image'
    ];

    // public function category(){
    //     return $this->belongsTo(\App\Category::class,'category_id');
    // }

    public function user(){
        return $this->belongsTo(\App\User::class,'user_id');
    }

    public function comments(){
        return $this->hasMany(\App\Comment::class,'post_id', 'id');
      }

    public function tags(){
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }
}
