@extends('layouts.app')
@section('title','ユーザー情報')
@section('content')
<div>
    <div class="panel-heading" style="text-align:center;">{{ $user->name }}さんのプロフィール
    </div>
    <div>
        <div style="text-align:center;">
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
        
      <p>ID：{{ $user->id }}</p>
      <p>名前：{{ $user->name }}</p>
      <p>メールアドレス：{{ $user->email }}</p>
    
    </div>  



<div class="panel-body">
    <!-- tabのcssのクラス -->
    <div class="tab-wrap">
        <input id="TAB-01" type="radio" name="TAB" class="tab-switch" checked="checked" /><label class="tab-label" for="TAB-01">posts</label>
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

                            <p class="card-text">{{ $post->content }}</p>

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
        <input id="TAB-02" type="radio" name="TAB" class="tab-switch" /><label class="tab-label" for="TAB-02">ボタン 2</label>
        <div class="tab-content">
            コンテンツ 2
        </div>
        <input id="TAB-03" type="radio" name="TAB" class="tab-switch" /><label class="tab-label" for="TAB-03">ボタン 3</label>
        <div class="tab-content">
            コンテンツ 3
        </div>
    </div>
</div>
@endsection