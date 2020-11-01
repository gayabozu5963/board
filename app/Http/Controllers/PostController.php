<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\User;
use App\Tag;
use App\Comment;

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

        if(isset($q['category_id'])){
            $posts = Post::latest()->where('category_id', $q['category_id'])->paginate(5);
            $posts->load('category', 'user', 'tags');

            return view('posts.index', [
                'posts' => $posts,
                'category_id' => $q['category_id']
            ]);

        } if(isset($q['tag_name'])){

            $posts = Post::latest()->where('content', 'like', "%{$q['tag_name']}%")->paginate(5);
            $posts->load('category', 'user', 'tags');

            return view('posts.index', [
                'posts' => $posts,
                'tag_name' => $q['tag_name']
            ]);

        }else {
            $posts = Post::latest()->paginate(5);
            $posts->load('category', 'user', 'tags');

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
                // $input = $request->only($post->getFillable());
                $post->user_id = $request->user_id;
                $post->category_id = $request->category_id;
                $post->content = $request->content;
                $post->title = $request->title;
    
                // $file = $request->file('image');
                // $name = $file->getClientOriginalName();
                //アスペクト比を維持、画像サイズを横幅1080pxにして保存する。
                // InterventionImage::make($file)->resize(1080, null, function ($constraint) {$constraint->aspectRatio();})->save(public_path('/image/' . $filename ) );;
    
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
            $post->category_id = $request->category_id;
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
        $post->load('category','user','comments.user'); //遅延ローディング
        
        return view('posts.show',['post'=> $post,]);
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
        $posts = Post::where('title', 'like', "%{$request->search}%")
        ->orWhere('content', 'like', "%{$request->search}%")
        ->paginate(5);
        
        $search_result = $request->search.'の検索結果'.$posts->total().'件';

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
}
