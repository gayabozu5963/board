@extends('layouts.app')
@section('content')
<div class="panel-heading"style = "
                        font-size: 20px;
                        font-weight: 600;">Title：{{ $post->title }}</div>
<div class="panel-body">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
           <!--user image -->
           @if(!empty($post->user->pro_image))
                <div style = "display: flex;">
                    <img src="{{ asset('storage/pro_image/'.$post->user->pro_image) }}" class="pro_image" 
                        style= "width: 50px;
                        height: 50px;
                        background: #eee;
                        border-radius: 50%;
                        box-shadow: 0 2px 3px 1px rgb(0, 0, 0);
                        object-fit: cover;
                        ">
                
                    <div style = "flex-direction: column; padding-left: 10px;">
                        <!-- user name -->
                        <a href="{{ route('users.show', $post->user_id) }}">
                            {{ $post->user->name }}
                        </a>
                        投稿日時：{{$post->created_at}}
                        <!-- title -->
                        <p class="card-title" style = "
                        font-size: 20px;
                        font-weight: 400;">
                            Category ： {{ $post->category->category_name }}
                        </p>
                    </div>
                </div>
                
            @else
            <div style = "display: flex;">
                <img src="{{ asset('storage/noimage/noimage.png') }}" class="noimage" 
                    style= "width: 50px;
                    height: 50px;
                    background: #eee;
                    border-radius: 50%;
                    ">
                    <div style = "flex-direction: column; padding-left: 10px;">
                        <!-- user name -->
                        <a href="{{ route('users.show', $post->user_id) }}">
                            {{ $post->user->name }}
                        </a>
                        投稿日時：{{$post->created_at}}
                        <!-- title -->
                        <p class="card-title" style = "
                        font-size: 20px;
                        font-weight: 400;">
                            Category ： {{ $post->category->category_name }}
                        </p>
                    </div>
            </div>
            @endif
            
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
            <p class="card-text" style = "
                        font-size: 20px;
                        font-weight: 600;">
            {{$post->content}}</p>
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
                            投稿日時：{{$comment->created_at}}
                    </p>
                    <div style="padding-left: 30px;">
                        <p class="card-text">{{ $comment->comment }}</p>
                    </div>
                </div>
            </div>
            <div style="padding-left: 30px;">
            <a href="{{ route('replies.create',['comment_id' => $comment->id]) }}">
            <i class="fas fa-reply"></i>
            </a>
                <?php $i=0; ?>
                @foreach($comment->replies as $replie)
                <?php $i++; ?>
                @endforeach
                @if($i == 0)
                @else
                {{$i}}
                @endif
            <i class="far fa-heart"></i>
            </div>
            
            <hr>
            <div class="reply" style="padding-left: 30px;">
                <div style="color: #494949;background: transparent;border-left: solid 5px #7db4e6;">
                    @if(!empty($comment->replies))
                        @foreach($comment->replies as $replie)
                        <div style="padding-left: 20px;">
                            @if(!empty($replie->user->pro_image))
                                <img src="{{ asset('storage/pro_image/'.$replie->user->pro_image ) }}" class="pro_image" 
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
                        
                            <a href="{{ route('users.show', $replie->user->id) }}">
                                {{ $replie->user->name }}
                            </a>
                            <div style="padding-left: 30px;">
                            <p class="card-text">{{ $replie->replie }}</p>
                            </div>
                            <p style="padding-left: 30px; font-size: 12px; ">
                            返信日時：{{$replie->created_at}}
                            </p>
                        </div>

                            <hr>
                        @endforeach
                    @else
                    @endif
                </div>
            </div>
        @endforeach
        <a href="{{ route('comments.create', ['post_id' => $post->id]) }}" class="btn btn-primary">コメントする <i class="fas fa-comments"></i></a>
    </div>
 
</div>
@endsection
