<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReplieRequest;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Replie;
use App\User;
use App\Like;

class ReplieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $q = \Request::query();

        $comment_id = $request->all('comment_id');

        $commentid = $request->input('comment_id');

        $replie_id = $request->input('replie_id');


        $replies = Replie::where('replies.id', $replie_id)
        ->get();
        $replies->load('user');

        $comments = Comment::with(['user', 'replies', 'replies.user'])
        ->where('comments.id', $commentid)
        ->get();

        $post_id = \App\Comment::select('post_id')
        ->where('id', $comment_id)
        ->get();

        return view('replies.create', [
            'comment_id' => $q['comment_id'],
            'comments' => $comments,
            'replies' => $replies,
            'post_id' => $post_id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReplieRequest $request)
    {
        $replie = new Replie;
        $input = $request->only($replie->getFillable());
        $replie = $replie->create($input);
        

        $post_id = $request->get('post_id');

        $num = preg_replace('/[^0-9]/', '', $post_id);
        
        return redirect('/posts/'.$num);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


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

        return redirect()->to(url()->previous() . "#{$id}");

        // return redirect()->back();
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

        return redirect()->to(url()->previous() . "#{$id}");


        // return redirect()->back();
    }
}
