<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fav extends Model
{
    // 配列内の要素を書き込み可能にする
  protected $fillable = ['post_id','user_id'];

  public function post()
  {
    return $this->belongsTo(Post::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
