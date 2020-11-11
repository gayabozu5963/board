@extends('layouts.app')
@section('title','ユーザー情報')
@section('content')
<div>
    <div class="panel-heading" style="text-align:center;">{{ $user->name }}さんのプロフィール
    </div>
    <div>
        <div style="text-align:center;">
        <p>ID：{{ $user->id }}</p>
      <p>名前：{{ $user->name }}</p>
      @if(Auth::user()->id == $user->id)
      <p><i class="fas fa-lock"></i>メールアドレス：{{ $user->email }}</p>
      @else
      @endif

        @if(!empty($user->pro_image))
        <img src="{{ asset('storage/pro_image/'.$user->pro_image) }}" class="pro_image" style= "width: 200px;
                height: 200px;
                background: #eee;
                border-radius: 50%;
                box-shadow: 0 2px 3px 1px rgb(0, 0, 0);
                object-fit: cover;
                ">
        @else
        <img src="{{ asset('storage/noimage/noimage.png') }}" class="noimage" 
                    style= "width: 200px;
                height: 200px;
                background: #eee;
                border-radius: 50%;
                box-shadow: 0 2px 3px 1px rgb(0, 0, 0);
                object-fit: cover;
                    ">
        @endif
        <div>
        

    </div>

    <div class="p-2 d-flex flex-column align-items-center">
        <p class="font-weight-bold">フォロー数{{ $follow_count }}</p>
        
    </div>
    <div class="p-2 d-flex flex-column align-items-center">
        <p class="font-weight-bold">フォロワー数{{ $follower_count }}</p>
        
    </div>

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



<div class="panel-body">
    <!-- tabのcssのクラス -->
    <div class="tab-wrap">
        <input id="TAB-01" type="radio" name="TAB" class="tab-switch" checked="checked" /><label class="tab-label" for="TAB-01">post</label>
        <div class="tab-content">
               <!-- <div class="card-body"> -->
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @foreach($user->posts as $post)
                    <div class="card">
                    <div class="card-body">
                            <h5 class="card-title">title ：{{ $post->title }}</h5>
                            <!-- {{-- <h5 class="card-title">
                                カテゴリー:
                                    <a href="{{ route('posts.index', ['category_id' => $post->category_id]) }}">
                                    {{ $post->category->category_name }}
                                </a>
                            </h5> --}} -->

                            <p class="card-text">{!! nl2br(e($post->content)) !!}</p>

                            @if (!empty($post->image))
                            <a href="{{ route('posts.show_pic', $post->image) }}">
                            <img src="{{ asset('storage/image/'.$post->image) }}"　style= "width: 250px;
                                height: 250px;
                                object-fit: contain;
                                
                                margin-right: 3%;
                                <!-- border: 2px solid #ccc; -->
                                background: #eee;
                                border-radius: 35px;"
                                > 
                            </a>
                            @else
                            @endif  
                    </div>
                    <br>
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">詳細</a>
                    </div>
                    <hr>
                @endforeach
                
        </div>
        <input id="TAB-02" type="radio" name="TAB" class="tab-switch" /><label class="tab-label" for="TAB-02">fav</label>
        <div class="tab-content">
        @foreach($fav_posts as $fav_post)
        {{$fav_post->title}}
        


        <hr>
        @endforeach
        </div>
        <input id="TAB-03" type="radio" name="TAB" class="tab-switch" /><label class="tab-label" for="TAB-03">luv</label>
        <div class="tab-content">
            コンテンツ 3
        </div>
    </div>
</div>
@endsection