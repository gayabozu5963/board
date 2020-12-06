@extends('layouts.app')
@section('content')
<div class="panel-heading">
    <h5 class="card-title">
        <p style="word-wrap: break-word;">title ：{!! nl2br(e($post->title)) !!}</p>    
    </h5>
</div>
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
                    </div>
                </div>
            @else
            <div style = "display: flex;">
                <img src="{{ asset('storage/noimage/noimage.png') }}" class="noimage" 
                    style= "width: 50px;
                    height: 50px;
                    border-radius: 50%;
                    ">
                    <div style = "flex-direction: column; padding-left: 10px;">
                        <!-- user name -->
                        <a href="{{ route('users.show', $post->user_id) }}">
                            {{ $post->user->name }}
                        </a>
                        投稿日時：{{$post->created_at}}
                    </div>
            </div>
            @endif
            @if (!empty($post->image))
            <a href="{{ route('posts.show_pic', $post->image) }}">
            <h5>
            <img src="{{ asset('storage/image/'.$post->image) }}" style= "width: 250px;height: 250px;object-fit: contain;margin-right: 3%;border-radius: 35px;"> 
            </h5>
            </a>
            @else
            @endif
            <p class="card-text" style = "font-size: 20px;font-weight: 600;">
            {!! nl2br(e($post->content)) !!}</p>
            <hr>
        </div>
    </div>


    <div class="p-3">
        <h4 class="">スレッド一覧　</h4>
        <hr>
        <!-- コメント -->
        @foreach($post->comments as $comment)
            <div class="card">
                <div class="card-body">
                    <p class="card-text">
                        @if(!empty($comment->user->pro_image))
                            <img src="{{ asset('storage/pro_image/'.$comment->user->pro_image) }}" class="pro_image" 
                                style= "width: 25px;
                                height: 25px;
                                border-radius: 50%;
                                box-shadow: 0 2px 3px 1px rgb(0, 0, 0);
                                object-fit: cover;
                                ">
                        @else
                            <img src="{{ asset('storage/noimage/noimage.png') }}" class="noimage" 
                                style= "width: 25px;
                                height: 25px;
                                border-radius: 50%;
                                ">
                        @endif
                            <a href="{{ route('users.show', $comment->user->id) }}">
                                {{ $comment->user->name }}
                            </a>
                            投稿日時：{{$comment->created_at}}
                    </p>

                    <div style="padding-left: 30px;">
                        <p style="word-wrap: break-word;">{!! nl2br(e($comment->comment)) !!}</p>    
                    </div>
                </div>
            </div>
            <div style="padding-left: 30px;display: flex;">
                <div style = "flex-direction: column; ">
                    <!-- コメントのリプライボタン -->
                    <a href="{{ route('replies.create',['comment_id' => $comment->id]) }}">
                        <i class="fas fa-reply"></i>
                    </a>

                    <!-- <?php
                        $i=0;
                        $reply_id=0; 
                    ?>
                    @foreach($comment->replies as $replie)
                        <?php 
                            $i++; 
                            $reply_id = $replie->id;
                        ?>
                    @endforeach

                    @if($i == 0)
                    @else
                        @if(!empty($comment->replies))
                            <a class="js-button"value="返信を表示" onclick="clickBtn1({{$reply_id}})" >{{$i}}件の返信</a>
                        @else
                        @endif
                    @endif -->

                    
                </div>
                <!-- いいね -->
                <div style = "flex-direction: column;padding-left: 15px;" >
                @if($comment->is_liked_by_auth_user())
                    <a id="{{$comment->id}}" href="{{ route('comment.unlike', ['id' => $comment->id]) }}" ><i class="fas fa-heart heart_red"></i></a>
                    {{ $comment->likes->count() }}
                @else
                    <a id="{{$comment->id}}" href="{{ route('comment.like', ['id' => $comment->id]) }}" ><i class="far fa-heart heart_red"></i></a>
                    @if($comment->likes->count() == '0')
                    @else
                    {{ $comment->likes->count() }}
                    @endif
                @endif
                </div>
            </div>
            <hr>
            <!-- コメントに対するリプライ内容 -->
            <!-- コメントに対するリプライがある時 -->
            @if(!empty($comment->replies))
                <div class="reply" style="padding-left: 10px;">
                    <div class="reply_a" id="{{$reply_id}}" style="color: #494949;background: transparent;border-left: solid 3px #7db4e6;">
                        @foreach($comment->replies as $replie)
                            @if(empty($replie->repliereplie_id))
                            <!-- コメントに対するリプのみ-->
                                    <div style="padding-left: 20px;">
                                        @if(!empty($replie->user->pro_image))
                                            <img src="{{ asset('storage/pro_image/'.$replie->user->pro_image ) }}" class="pro_image" 
                                            style= "width: 25px;
                                            height: 25px;
                                            border-radius: 50%;
                                            box-shadow: 0 2px 3px 1px rgb(0, 0, 0);
                                            object-fit: cover;
                                            ">
                                        @else
                                            <img src="{{ asset('storage/noimage/noimage.png') }}" class="noimage" 
                                                style= "width: 25px;
                                                height: 25px;
                                                border-radius: 50%;
                                                ">
                                        @endif
                                        <a href="{{ route('users.show', $replie->user->id) }}">
                                            {{ $replie->user->name }}
                                        </a>
                                        <div style="padding-left: 30px;">
                                            <p class="card-text">{!! nl2br(e($replie->replie)) !!}</p>
                                        </div>
                                        <p style="padding-left: 30px; font-size: 12px; ">
                                        返信日時：{{$replie->created_at}}
                                        </p>
                                        <div style="padding-left: 30px;display: flex;">
                                            <div style = "flex-direction: column;">
                                                <!-- リプライのリプライ -->
                                                <a href="{{ route('replies.create',['comment_id' => $comment->id,'replie_id' => $replie->id]) }}">
                                                    <i class="fas fa-reply"></i>
                                                </a>
                                            </div>
                                            <!-- コメントに対するリプライのいいね -->
                                            <div style = "flex-direction: column;padding-left: 15px;">
                                                @if($replie->is_liked_by_auth_user())
                                                    <a href="{{ route('replie.unlike', ['id' => $replie->id]) }}" class=""><i class="fas fa-heart"></i></a>{{ $replie->likes->count() }}
                                                @else
                                                    <a href="{{ route('replie.like', ['id' => $replie->id]) }}" class=""><i class="far fa-heart"></i></a>
                                                    @if($replie->likes->count() == '0')
                                                    @else
                                                    {{ $replie->likes->count() }}
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                            @else
                            @endif
                                <div class="reply" style="padding-left: 25px;">
                                    <div class="reply_a" id="" style="color: #494949;background: transparent;border-left: solid 3px #7db4e6;">
                                        @foreach($repliereplies as $repliereplie)
                                            @if($repliereplie->repliereplie_id == $replie->id)
                                                <!-- リプライリプライIDがNULLじゃない時 -->
                                                    <!-- リプに対するリプ -->
                                                        <div style="padding-left: 20px;">
                                                            @if(!empty($repliereplie->user->pro_image))
                                                                <img src="{{ asset('storage/pro_image/'.$repliereplie->user->pro_image ) }}" class="pro_image" 
                                                                style= "width: 25px;
                                                                height: 25px;
                                                                border-radius: 50%;
                                                                box-shadow: 0 2px 3px 1px rgb(0, 0, 0);
                                                                object-fit: cover;
                                                                ">
                                                            @else
                                                                <img src="{{ asset('storage/noimage/noimage.png') }}" class="noimage" 
                                                                    style= "width: 25px;
                                                                    height: 25px;
                                                                    border-radius: 50%;
                                                                    ">
                                                            @endif
                                                            <a href="{{ route('users.show', $repliereplie->user->id) }}">
                                                                {{ $repliereplie->user->name }}
                                                            </a>
                                                            <div style="padding-left: 30px;">
                                                                <p class="card-text">{!! nl2br(e($repliereplie->replie)) !!}</p>
                                                            </div>
                                                            <p style="padding-left: 30px; font-size: 12px; ">
                                                            返信日時：{{$repliereplie->created_at}}
                                                            </p>
                                                            <div style="padding-left: 30px;display: flex;">
                                                                <div style = "flex-direction: column;">
                                                                    <!-- リプライ -->
                                                                    <a href="{{ route('replies.create',['comment_id' => $comment->id,'replie_id' => $replie->id]) }}">
                                                                        <i class="fas fa-reply"></i>
                                                                    </a>
                                                                </div> 
                                                                    <!-- コメントに対するリプライのいいね -->
                                                                <div style = "flex-direction: column;padding-left: 15px;">
                                                                    @if($repliereplie->is_liked_by_auth_user())
                                                                        <a href="{{ route('repliereplie.unlike', ['id' => $repliereplie->id]) }}" class=""><i class="fas fa-heart"></i></a>{{ $repliereplie->likes->count() }}
                                                                    @else
                                                                        <a href="{{ route('repliereplie.like', ['id' => $repliereplie->id]) }}" class=""><i class="far fa-heart"></i></a>
                                                                        @if($repliereplie->likes->count() == '0')
                                                                        @else
                                                                        {{ $repliereplie->likes->count() }}
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                            @else
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                        @endforeach  
                    </div>
                </div>
            @else
            @endif
        @endforeach





        @guest
        @else
        <!-- モーダル用 -->
        <div>
            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                            <a class="fixed_btn" class="btn btn-success" data-toggle="modal" data-target="#modalForm" data-cusno=1 data-visitday="2019-07-01"style= "text-align: center;">
                                <i class="fas fa-heartbeat"data-backdrop="true"></i> 
                            </a>
                            <!-- Modal の中身 -->
                            <div class="modal fade" id="modalForm" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <!-- Modal ヘッダー -->
                                    <div class="modal-header">
                                        コメント
                                        <button type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">×</span>
                                        <span class="sr-only">閉じる</span>
                                        </button>
                                    </div>

                                    <form action="{{ route('comments.store')}}" method="POST">
                                    {{ csrf_field() }}
                                        <div class="modal-body">
                                                <div class="form-group">
                                                <label for="comment">Comment</label>
                                                <textarea class="form-control" rows="5" id="comment" name="comment"></textarea>
                                                </div>
                                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                        </div>
                                        <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        </div> 
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        @endguest

        <a href="{{ route('comments.create', ['post_id' => $post->id]) }}" class="btn btn-primary">コメントする <i class="fas fa-comments"></i></a>
    </div>
</div>
@endsection