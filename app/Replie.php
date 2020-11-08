<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Replie extends Model
{


    protected $fillable = [
        'replie','user_id','comment_id'
    ];

    // リプライは一人の投稿者に従属
    public function user(){
        return $this->belongsTo('App\User');
    }

    // コメントは複数のリプライを持ち、リプライは一つのコメントに従属
    public function comment(){
        return $this->belongsTo('App\Comment');
    }

    public function likes()
    {
      return $this->hasMany(Like::class, 'replie_id');
    }
    
    /**
    * リプライにLIKEを付いているかの判定
    *
    * @return bool true:Likeがついてる false:Likeがついてない
    */
    public function is_liked_by_auth_user()
    {
        $id = Auth::id();

        $likers = array();
        foreach($this->likes as $like) {
        array_push($likers, $like->user_id);
        }

        if (in_array($id, $likers)) {
        return true;
        } else {
        return false;
        }
    }
}
