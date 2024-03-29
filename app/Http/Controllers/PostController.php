<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\User;
use App\Tag;
use App\Fav;
use App\Like;
use App\Replie;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q = \Request::query();

        // if(isset($q['category_id'])){
        //     $posts = Post::latest()->where('category_id', $q['category_id'])->paginate(5);
        //     $posts->load('category', 'user', 'tags');

        //     return view('posts.index', [
        //         'posts' => $posts,
        //         'category_id' => $q['category_id']
        //     ]);

        // } if(isset($q['tag_name'])){

        //     $posts = Post::latest()->where('content', 'like', "%{$q['tag_name']}%")->paginate(5);
        //     $posts->load('category', 'user', 'tags');

        //     return view('posts.index', [
        //         'posts' => $posts,
        //         'tag_name' => $q['tag_name']
        //     ]);

        // }else {
        //     $posts = Post::latest()->paginate(5);
        //     $posts->load('category', 'user', 'tags');

        //     return view('posts.index', [
        //         'posts' => $posts,
        //     ]);
        // }

         if(isset($q['tag_name'])){
            $posts = Post::latest()->where('content', 'like', "%{$q['tag_name']}%")->paginate(10);
            $posts->load('user', 'tags');

            return view('posts.index', [
                'posts' => $posts,
                'tag_name' => $q['tag_name']
            ]);
        }else {
            $posts = Post::latest()->paginate(10);
            $posts->load('user', 'tags');

            return view('posts.index', [
                'posts' => $posts,
            ]);
        }
  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create',[]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        if(!empty($request->file('image'))){
            if($request->file('image')->isValid()) {
                $post = new Post;
                $post->user_id = $request->user_id;
                // $post->category_id = $request->category_id;
                $post->content = $request->content;
                $post->title = $request->title;
       
                $filename = $request->file('image')->store('public/image');
    
                $post->image = basename($filename);
    
                // contentからtagを抽出
                preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $request->content, $match);
    
                $tags = [];
                foreach ($match[1] as $tag) {
                    $found = Tag::firstOrCreate(['tag_name' => $tag]);
    
                    array_push($tags, $found);
                }
    
                $tag_ids = [];
    
                foreach ($tags as $tag) {
                    array_push($tag_ids, $tag['id']);
                }
    
                $post->save();
                $post->tags()->attach($tag_ids);
            }
        }else{
            $post = new Post;
            // $input = $request->only($post->getFillable());
            $post->user_id = $request->user_id;
            // $post->category_id = $request->category_id;
            $post->content = $request->content;
            $post->title = $request->title;

            // contentからtagを抽出
            preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $request->content, $match);

            $tags = [];
            foreach ($match[1] as $tag) {
                $found = Tag::firstOrCreate(['tag_name' => $tag]);

                array_push($tags, $found);
            }

            $tag_ids = [];

            foreach ($tags as $tag) {
                array_push($tag_ids, $tag['id']);
            }

            $post->save();
            $post->tags()->attach($tag_ids);
        }
        

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load('user','comments'); //遅延ローディング

        $comments = $post->comments;

        // 投稿に存在するコメントのIDを配列で取得
        $comment_ids = array();
        foreach($comments as $comment){
            array_push($comment_ids, $comment->id);
        }

        $repliereplies = 0;
        // 投稿にコメントが存在する場合
        if($comment_ids){
            // コメントに対するリプライを取得
            $comment_replies = Replie::whereIn('comment_id', $comment_ids)
            ->get();
            
            
            $repliereplie_ids = array();
            foreach($comment_replies as $comment_replie){
                array_push($repliereplie_ids, $comment_replie->repliereplie_id);
            }

            $repliereplies = Replie::whereIn('repliereplie_id', $repliereplie_ids)
            ->get();
        }
        
        return view('posts.show',[
            'post'=> $post,
            'repliereplies'=> $repliereplies
        ]);
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

    public function search(Request $request)
    {

        $posts = Post::select('posts.*')->join('users','posts.user_id','=',"users.id")
        ->where('title', 'like', "%{$request->search}%")
        ->orWhere('content', 'like', "%{$request->search}%")
        ->orWhere('users.name', 'like', "%{$request->search}%")
        ->orWhere('users.unique_id', 'like', "%{$request->search}%")
        ->paginate(5);

        
        $search_result = '「'.$request->search.'」の検索結果 '.$posts->total().'件';

        return view('posts.index', [
            'posts' => $posts,
            'search_result' => $search_result,
            'search_query'  => $request->search
        ]);
    }

    public function rep()
    {
        $comments = Comment::with(['user', 'replies', 'replies.user'])
            ->where('comments.post_id', $post_id)
            ->get();

        return view('replies.create', [
            'comments' => $comments,
        ]);
    }

    public function show_pic(Request $request)
    {
        $pict = $request->image;
        return view('posts.show_pict', [
            'pict' => $pict,
        ]);
    }

    /**
     * 引数のIDに紐づくリプライにLIKEする
    *
    * @param $id リプライID
    * @return \Illuminate\Http\RedirectResponse
    */
    public function fav($id)
    {
        Fav::create([
        'post_id' => $id,
        'user_id' => Auth::id(),
        ]);

        session()->flash('success', 'You Liked the Post.');

        return redirect()->back();
    }

    /**
     * 引数のIDに紐づくリプライにUNLIKEする
     *
     * @param $id リプライID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unfav($id)
    {
        $fav = Fav::where('post_id', $id)->where('user_id', Auth::id())->first();
        $fav->delete();

        session()->flash('success', 'You Unliked the Post.');

        return redirect()->back();
    }
}
