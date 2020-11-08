<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
      // 配列内の要素を書き込み可能にする
  protected $fillable = ['replie_id','comment_id','user_id'];

  public function replie()
  {
    return $this->belongsTo(Replie::class);
  }

  public function comment()
  {
    return $this->belongsTo(Comment::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
