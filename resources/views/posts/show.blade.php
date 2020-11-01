@extends('layouts.app')
@section('content')
<div class="panel-heading">{{ $post->title }}</div>
<div class="panel-body">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <!-- <h5 class="card-title">title ： {{ $post->title }}</h5> -->
            <h5 class="card-title">
                Category ： {{ $post->category->category_name }}
            </h5>
            <h5 class="card-title">
                UserName ： {{ $post->user->name }}
            </h5>
            <p class="card-text">
            Comment ：{{$post->content}}</p>

            
            @if (!empty($post->image))
            <img src="{{ asset('storage/image/'.$post->image) }}"　style= "width: 250px;
                height: 250px;
                object-fit: contain;
                
                margin-right: 3%;
                <!-- border: 2px solid #ccc; -->
                background: #eee;
                border-radius: 35px;"
                > 
            @else
            @endif

            <!-- <a href="{{ route('posts.show' ,$post->id)}}" class="btn btn-primary">詳細</a> -->
            <hr>
        </div>
    </div>

    <div class="p-3">
        <h4 class="card-title">スレッド一覧　</h4>
        <hr>
        @foreach($post->comments as $comment)
            <div class="card">
                <div class="card-body">
                <p class="card-text">
                    @if(!empty($comment->user->pro_image))
                        <img src="{{ asset('storage/pro_image/'.$comment->user->pro_image) }}" class="pro_image" 
                            style= "width: 25px;
                            height: 25px;
                            background: #eee;
                            border-radius: 50%;
                            box-shadow: 0 2px 3px 1px rgb(0, 0, 0);
                            object-fit: cover;
                            ">
                    @else
                        <img src="{{ asset('storage/noimage/noimage.png') }}" class="noimage" 
                            style= "width: 25px;
                            height: 25px;
                            background: #eee;
                            border-radius: 50%;
                            ">
                    @endif
                    
                        <a href="{{ route('users.show', $comment->user->id) }}">
                            {{ $comment->user->name }}
                        </a>
                    </p>
                    <p class="card-text">　　{{ $comment->comment }}</p>
                </div>
            </div>
            <a href="{{ route('replies.create',['comment_id' => $comment->id]) }}">
                <i class="fas fa-reply"></i>
            </a>
            <i class="far fa-heart"></i>
            <hr>
        @endforeach
        <a href="{{ route('comments.create', ['post_id' => $post->id]) }}" class="btn btn-primary">コメントする <i class="fas fa-comments"></i></a>
    </div>
 
</div>
@endsection
