@extends('layouts.app')
@section('title','ユーザー情報')
@section('content')
<div >
    <p class="card-title" style="text-align:center;">
        {{ $user->name }}
    </p>
    
    
</div>
<div class="panel-body" >
    <div>
        <div style="text-align:center;">
            
            @if(Auth::user()->id == $user->id)
            <p><i class="fas fa-lock"></i>メールアドレス：{{ $user->email }}</p>
            
            @else
            @endif
            @if(!empty($user->pro_image))
            <img src="{{ asset('storage/pro_image/'.$user->pro_image) }}" class="pro_image" style= "width: 200px;
                    height: 200px;
                    border-radius: 50%;
                    box-shadow: 0 2px 3px 1px rgb(0, 0, 0);
                    object-fit: cover;
                    ">
            @else
            <img src="{{ asset('image/noimage.png') }}" class="noimage" 
                    style= "width: 200px;
                    height: 200px;
                    border-radius: 50%;
                    box-shadow: 0 2px 3px 1px rgb(0, 0, 0);
                    object-fit: cover;
                ">
            @endif
        </div>
        <div style="text-align:center;">
        ID：{{ $user->unique_id }}
        </div>

        <div style="text-align:center;">
        @if(Auth::user()->id == $user->id)
        <br>
            <a href="{{ route('user.userEdit') }}" class="btn btn-primary btn-sm">プロフィールの編集</a>
        @else
        @endif
        </div>

        
        <br>
        @if($user->self)
        <p style="text-align:center;font-weight: 600;">自己紹介<br></p>

        <div style="text-align:center;">
            <p style="word-wrap: break-word;">{!! nl2br(e($user->self)) !!}</p>
        </div>
        @else
        @endif
        
    </div>
   

    <div style = "display: flex;justify-content: center;">

        <a href="{{ route('user.follow_show', ['id' => $user->id]) }}">
            <div style="text-align:center;flex-direction: center;">
                <p class="font-weight-bold">フォロー数{{ $follow_count }}　</p>
            </div>
        </a>

        <a href="{{ route('user.follower_show', ['id' => $user->id]) }}">
            <div style="text-align:center;flex-direction: center;">
                <p class="font-weight-bold">フォロワー数{{ $follower_count }}</p>
            </div>
        </a>

    </div>



    <div style="text-align:center;">
    @if(Auth::user()->id == $user->id)
    @else
        @if (auth()->user()->isFollowed($user->id))
            <div class="px-2">
                <span class="px-1 bg-secondary text-light">フォローされています</span>
            </div>
        @endif

        @if (auth()->user()->isFollowing($user->id))
            <form action="{{ route('unfollow', ['id' => $user->id]) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <button type="submit" class="btn btn-danger">フォロー解除</button>
            </form>
        @else
            <form action="{{ route('follow', ['id' => $user->id]) }}" method="POST">
                {{ csrf_field() }}

                <button type="submit" class="btn btn-primary">フォローする</button>
            </form>
        @endif  
    @endif
    </div>
<!-- tabのcssのクラス -->
    <div class="tab-wrap">
<!-- 自分の投稿 -->
        <input id="TAB-01" type="radio" name="TAB" class="tab-switch" checked="checked" /><label class="tab-label" for="TAB-01">投稿</label>
        <div class="tab-content">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @foreach($posts as $post)
                    <div class="card">
                        <div class="card-body" >
                                    <h5 class="card-title">
                                    <p style="word-wrap: break-word;">title ：{!! nl2br(e($post->title)) !!}</p>    
                                    </h5>
                                    @if (!empty($post->image))
                                    <a href="{{ route('posts.show_pic', $post->image) }}">
                                    <img src="{{ asset('storage/image/'.$post->image) }}"　style= "width: 250px;
                                        height: 250px;
                                        object-fit: contain;
                                        margin-right: 3%;
                                        border-radius: 35px;"
                                        > 
                                    </a>
                                    @else
                                    @endif
                        </div>
                        <p>投稿日時：{{$post->created_at}}</p>
                        <br>
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">詳細</a>
                    </div>
                    <hr>
                @endforeach       
        </div>
<!-- お気に入り投稿 -->
        <input id="TAB-02" type="radio" name="TAB" class="tab-switch" /><label class="tab-label" for="TAB-02">お気に入り</label>
        <div class="tab-content">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @foreach($fav_posts as $fav_post)
                <div class="card">
                <div class="card-body">
                @if(!empty($fav_post->user->pro_image))
                        <img src="{{ asset('storage/pro_image/'.$fav_post->user->pro_image) }}" class="pro_image" 
                            style= "width: 25px;
                            height: 25px;
                            border-radius: 50%;
                            box-shadow: 0 2px 3px 1px rgb(0, 0, 0);
                            object-fit: cover;
                            ">
                @else
                    <img src="{{ asset('image/noimage.png') }}" class="noimage" 
                    style= "width: 25px;
                    height: 25px;
                    border-radius: 50%;
                    ">
                @endif
                        <!-- user name -->
                        <a href="{{ route('users.show', $fav_post->user_id) }}">
                            {{ $fav_post->user->name }}
                        </a>
                        さんの投稿
                        <!-- title -->
                        <br>
                        <h5 class="card-title">
                            <p style="word-wrap: break-word;">title ：{!! nl2br(e($fav_post->title)) !!}</p>    
                        </h5>
                            @if (!empty($fav_post->image))
                            <a href="{{ route('posts.show_pic', $fav_post->image) }}">
                            <img src="{{ asset('storage/image/'.$fav_post->image) }}"　style= "width: 250px;
                                height: 250px;
                                object-fit: contain;
                                margin-right: 3%;
                                border-radius: 35px;"
                                > 
                            </a>
                            @else
                            @endif  
                    </div>
                    <p>投稿日時：{{$fav_post->created_at}}</p>
                    <div style= "text-align: right;">
                        <div>
                            @if($fav_post->is_faved_by_auth_user())
                                <a href="{{ route('post.unfav', ['id' => $fav_post->id]) }}"><i class="fas fa-star"></i></a>
                            @else
                                <a href="{{ route('post.fav', ['id' => $fav_post->id]) }}"><i class="far fa-star"></i></a>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('posts.show', $fav_post->id) }}" class="btn btn-primary">詳細</a>
                    </div>
                    <hr>
                @endforeach
        </div>

<!-- いいねコメント -->
        <input id="TAB-03" type="radio" name="TAB" class="tab-switch" /><label class="tab-label" for="TAB-03">いいね</label>
        <div class="tab-content">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @foreach($like_comment_posts as $like_comment_post)
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">
                            @if(!empty($like_comment_post->user->pro_image))
                                <img src="{{ asset('storage/pro_image/'.$like_comment_post->user->pro_image) }}" class="pro_image" 
                                    style= "width: 25px;
                                    height: 25px;
                                    border-radius: 50%;
                                    box-shadow: 0 2px 3px 1px rgb(0, 0, 0);
                                    object-fit: cover;
                                    ">
                            @else
                                <img src="{{ asset('image/noimage.png') }}" class="noimage" 
                                    style= "width: 25px;
                                    height: 25px;
                                    border-radius: 50%;
                                    ">
                            @endif

                            <a href="{{ route('users.show', $like_comment_post->user->id) }}">
                                {{ $like_comment_post->user->name }}
                            </a>
                            さんのコメント
                        </p>
                        <h5 class="card-title">
                            <p style="word-wrap: break-word;">comment ：{!! nl2br(e($like_comment_post->comment)) !!}</p>    
                        </h5>
                        投稿日時：{{$like_comment_post->created_at}}
                    </div>
                </div>
                <!-- いいね -->
                <div style="text-align: right;">
                    @if($like_comment_post->is_liked_by_auth_user())
                        <a href="{{ route('comment.unlike', ['id' => $like_comment_post->id]) }}" ><i class="fas fa-heart heart_red"></i></a>
                        {{ $like_comment_post->likes->count() }}
                    @else
                        <a href="{{ route('comment.like', ['id' => $like_comment_post->id]) }}" ><i class="far fa-heart heart_red"></i></a>
                        @if($like_comment_post->likes->count() == '0')
                        @else
                        {{ $like_comment_post->likes->count() }}
                        @endif
                    @endif
                </div>
                <a href="{{ route('posts.show', $like_comment_post->post_id) }}" class="btn btn-primary">詳細</a>
                <hr>
            @endforeach

            @foreach($like_replie_posts as $like_replie_post)
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">
                            @if(!empty($like_replie_post->user->pro_image))
                                <img src="{{ asset('storage/pro_image/'.$like_replie_post->user->pro_image) }}" class="pro_image" 
                                    style= "width: 25px;
                                    height: 25px;
                                    border-radius: 50%;
                                    box-shadow: 0 2px 3px 1px rgb(0, 0, 0);
                                    object-fit: cover;
                                    ">
                            @else
                                <img src="{{ asset('image/noimage.png') }}" class="noimage" 
                                    style= "width: 25px;
                                    height: 25px;
                                    border-radius: 50%;
                                    ">
                            @endif

                            <a href="{{ route('users.show', $like_replie_post->user->id) }}">
                                {{ $like_replie_post->user->name }}
                            </a>
                            さんのリプライ
                        </p>
                        <h5 class="card-title">
                            <p style="word-wrap: break-word;">Reply ：{!! nl2br(e($like_replie_post->replie)) !!}</p>    
                        </h5>
                        投稿日時：{{$like_replie_post->created_at}}
                    </div>
                </div>
                <div style="text-align: right;">
                    @if($like_replie_post->is_liked_by_auth_user())
                        <a href="{{ route('replie.unlike', ['id' => $like_replie_post->id]) }}" ><i class="fas fa-heart heart_red"></i></a>
                        {{ $like_replie_post->likes->count() }}
                    @else
                        <a href="{{ route('replie.like', ['id' => $like_replie_post->id]) }}" ><i class="far fa-heart heart_red"></i></a>
                        @if($like_replie_post->likes->count() == '0')
                        @else
                        {{ $like_replie_post->likes->count() }}
                        @endif
                    @endif
                </div>
                <a href="{{ route('posts.show', $like_replie_post->post_id) }}" class="btn btn-primary">詳細</a>
                <hr>

                
            @endforeach

        </div>
    </div>
</div>
@endsection