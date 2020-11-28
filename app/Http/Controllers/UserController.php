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
use App\Replie;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {


        $all_users = $user->getAllUsers(auth()->user()->id);

        return view('user.index', [
            'all_users'  => $all_users
        ]);
       
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
        ->orderBy('posts.id','desc')
        ->get();
        $favs = Fav::where('user_id', $user_id)
        ->get();
        $likes = Like::where('user_id',$user_id)
        ->get();


// ファボの表示
        $post_ids = array();
        foreach($favs as $fav){
            array_push($post_ids, $fav->post_id);
        }
        $fav_posts = Post::whereIn('id', $post_ids)
        ->orderBy('posts.id','desc')
        ->get();

// いいねの表示
        $comment_ids = array();
        foreach($likes as $like){
            if($like->comment_id == !null){
                array_push($comment_ids, $like->comment_id);
            }
        }
        $like_comment_posts_unreverses = Comment::whereIn('id', $comment_ids)
        ->get();

        $like_comment_posts = array();
        foreach($like_comment_posts_unreverses as $like_comment_posts_unrevers){
            array_push($like_comment_posts, $like_comment_posts_unrevers);
        }

        $like_comment_posts = array_reverse($like_comment_posts);



// いいねした順に表示
        // $like_comment_posts = Comment::whereIn('comments.id', $comment_ids)
        //                     ->join('likes', 'likes.comment_id', '=', 'comments.id')
        //                     ->where('likes.user_id', Auth::user()->id) //ログインしている自分自身のid
        //                     ->orderBy('likes.created_at', 'DESC')
        //                     ->get();







        $replie_ids = array();
        foreach($likes as $like){
            if($like->replie_id == !null){
                array_push($replie_ids, $like->replie_id);
            }
        }

        $like_replie_posts = Replie::whereIn('id', $replie_ids)
        ->get();



        $user->load('posts','favs');
        // $like_comment_posts->load('user');
        $like_replie_posts->load('user');

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
            'like_replie_posts' => $like_replie_posts,
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
