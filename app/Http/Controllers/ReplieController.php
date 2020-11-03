<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReplieRequest;
use App\Comment;
use App\Replie;
use App\User;

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

        $comment_id = $request->all();

        $comments = Comment::with(['user', 'replies', 'replies.user'])
        ->where('comments.id', $comment_id)
        ->get();

        $post_id = \App\Comment::select('post_id')
        ->where('id', $comment_id)
        ->get();

        return view('replies.create', [
            'comment_id' => $q['comment_id'],
            'comments' => $comments,
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
}
