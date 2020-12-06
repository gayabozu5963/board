<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use Illuminate\Support\Facades\Auth;


class RepliereplieController extends Controller
{
        
    /**
     * 引数のIDに紐づくリプライにLIKEする
    *
    * @param $id リプライID
    * @return \Illuminate\Http\RedirectResponse
    */
    public function like($id)
    {
        Like::create([
        'replie_id' => $id,
        'user_id' => Auth::id(),
        ]);

        session()->flash('success', 'You Liked the Reply.');

        // return redirect()->to(url()->previous() . "#{$id}");

        return redirect()->back();
    }

    /**
     * 引数のIDに紐づくリプライにUNLIKEする
     *
     * @param $id リプライID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unlike($id)
    {
        $like = Like::where('replie_id', $id)->where('user_id', Auth::id())->first();
        $like->delete();

        session()->flash('success', 'You Unliked the Reply.');

        // return redirect()->to(url()->previous() . "#{$id}");


        return redirect()->back();
    }
}
