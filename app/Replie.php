<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
