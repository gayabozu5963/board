<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;

use App\Post;
use App\User;
use App\Fav;
use App\Follower;
use App\Comment;
use App\Like;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $authUser = Auth::user();
        $users = User::all();
        $param = [
            'authUser'=>$authUser,
            'users'=>$users
        ];
        return view('user.index',$param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user,Follower $follower,Comment $comment)
    {
        $q = \Request::query();

        // user_idを取得する。
        $user_id = $user->id;
        
        $posts = Post::where('user_id', $user_id)
        ->get();
        $favs = Fav::where('user_id', $user_id)
        ->get();
        $likes = Like::where('user_id',$user_id)
        ->get();

        // 配列を代入する変数の初期化
        $post_ids = array();

        foreach($favs as $fav){
            array_push($post_ids, $fav->post_id);
        }

        $fav_posts = Post::whereIn('id', $post_ids)
        ->get();


        $comment_ids = array();

        foreach($likes as $like){
            array_push($comment_ids, $like->comment_id);
        }
        $like_comment_posts = Comment::whereIn('id', $comment_ids)
        ->get();

        // $like_comments_posts = Post

        $user->load('posts','favs');

        $like_comment_posts->load('user');

        

        $login_user = auth()->user();
        $is_following = $login_user->isFollowing($user->id);
        $is_followed = $login_user->isFollowed($user->id);
        $follow_count = $follower->getFollowCount($user->id);
        $follower_count = $follower->getFollowerCount($user->id);

        return view('users.show', [
            'user' => $user,
            'posts' => $posts,
            'fav_posts' => $fav_posts,
            'like_comment_posts' => $like_comment_posts,
            'follow_count'   => $follow_count,
            'follower_count' => $follower_count

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
    
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

    public function userEdit(Request $request){
        $authUser = Auth::user();
        $param = [
            'authUser'=>$authUser,
        ];
        return view('user.userEdit',$param);
    }

    public function userUpdate(UserRequest $request){

        $inputs = $request->all();

        if(!empty($request->file('pro_image'))){
            // imageがnullじゃないときアップロードできたかの確認
            if($request->file('pro_image')->isValid()) {
                $user = User::find($inputs['user_id']);
    
                $user->name = $request->name;
                $user->email = $request->email;
                $user->self = $request->self;
    
                $filename = $request->file('pro_image')->store('public/pro_image');
    
                $user->pro_image = basename($filename);
    
                $user->save();
            }
        }else{
            $user = User::find($inputs['user_id']);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->self = $request->self;
            $user->save();
        }

        return redirect('/');
    }


        // フォロー
        public function follow(User $user)
        {
            $follower = auth()->user();

            // フォローしているか
            $is_following = $follower->isFollowing($user->id);
            if(!$is_following) {
                // フォローしていなければフォローする
                $follower->follow($user->id);
                return back();
            }
        }
    
        // フォロー解除
        public function unfollow(User $user)
        {
            $follower = auth()->user();
            // フォローしているか
            $is_following = $follower->isFollowing($user->id);
            if($is_following) {
                // フォローしていればフォローを解除する
                $follower->unfollow($user->id);
                return back();
            }
        }




}
