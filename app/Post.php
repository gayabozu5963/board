<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


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

    public function favs()
    {
      return $this->hasMany(Fav::class, 'post_id');
    }

    public function is_faved_by_auth_user()
    {
      $id = Auth::id();
  
      $favers = array();
      foreach($this->favs as $fav) {
        array_push($favers, $fav->user_id);
      }
  
      if (in_array($id, $favers)) {
        return true;
      } else {
        return false;
      }
    }
}
