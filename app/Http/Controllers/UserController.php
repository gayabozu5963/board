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
    public function show(User $user,Follower $follower,Fav $fav,Post $post)
    {
        $q = \Request::query();

        $posts = Post::latest();


        // indexブレードで選択したユーザのuser_idと一致するお気に入りテーブルの
        // user_idを取得する。



        $favs_post_ids = $post->load('favs');

        $user_id = $user->id;


        $favs = Fav::where('user_id', $user_id)
        ->get();
        

        // 配列を代入する変数の初期化
        $post_ids = array();

        foreach($favs as $fav){
            array_push($post_ids, $fav->post_id);
        }

        $fav_posts = Post::whereIn('id', $post_ids)
        ->get();
        


        $user->load('posts','favs');

        

        $login_user = auth()->user();
        $is_following = $login_user->isFollowing($user->id);
        $is_followed = $login_user->isFollowed($user->id);
        $follow_count = $follower->getFollowCount($user->id);
        $follower_count = $follower->getFollowerCount($user->id);

        return view('users.show', [
            'user' => $user,
            'posts' => $posts,
            'fav_posts' => $fav_posts,
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
    
                $filename = $request->file('pro_image')->store('public/pro_image');
    
                $user->pro_image = basename($filename);
    
                $user->save();
            }
        }else{
            $user = User::find($inputs['user_id']);

            $user->name = $request->name;
            $user->email = $request->email;
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
