@extends('layouts.app')
@section('content')
<div class="panel-body" >
    <div>
        <div style="text-align:center;" >
            <div>
                <h5 class="card-title"></h5>
                <div id="custom-search-input">
                    <div class="from-group">
                        <div class="input-group col-xs-4" >
                            <form action="{{ route('posts.search') }}" method="get">
                            {{csrf_field()}}
                                <div class="input-group">
                                        <input type="text" class="form-control"　placeholder="search" name="search" value="" style="min-width:200px">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="submit">
                                                <i class='fas fa-search'></i>
                                                </button>
                                            </span>
                                </div>
                                @isset($search_result)
                                        <h5 class="panel-title">{{ $search_result }}</h5>
                                @endisset
                            </form>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel-heading">Board</div>
<div class="panel-body" >

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @foreach($posts as $post)
    <div class="card">
        <div class="card-body">
            <!--ユーザー画像 -->
            @if(!empty($post->user->pro_image))
                <div style = "display: flex; word-wrap: break-word;">
                    <img src="{{ asset('storage/pro_image/'.$post->user->pro_image) }}" class="pro_image">
                    <div style = "flex-direction: column; padding-left: 10px;max-width: 80%;">
                        <!-- user name -->
                        <a href="{{ route('users.show', $post->user_id) }}">
                            {{ $post->user->name }}
                        </a>
                        {{'@'.$post->user->unique_id}}
                        <!-- title -->
                        <p class="card-title">
                            Title： {{ $post->title }}
                        </p>
                    </div>
                </div>
            <!--user noimage -->
            @else
            <div style = "display: flex;">
                <img src="{{ asset('storage/noimage/noimage.png') }}" class="pro_image">
                    <div style = "flex-direction: column; padding-left: 10px; max-width: 80%;">
                        <!-- user name -->
                        <a href="{{ route('users.show', $post->user_id) }}">
                            {{ $post->user->name }}
                        </a>
                        投稿日時：{{$post->created_at}}
                        <!-- title -->
                        <p class="card-title">
                            Title： {{ $post->title }}
                        </p>
                    </div>
            </div>
            @endif

            <!-- 投稿画像 -->
            @if (!empty($post->image))
            <a href="{{ route('posts.show_pic', $post->image) }}">
            <img src="{{ asset('storage/image/'.$post->image) }}"　style= "width: 250px;
                height: 250px;
                object-fit: contain;
                margin-right: 3%;
                border-radius: 35px;
                text-align:center;"
                >
            </a>
            @else
            @endif
            
            <!-- tag -->
            <h5>
                @foreach($post->tags as $tag)
                    @if (isset($tag->tag_name))
                    <i class="fas fa-tags"></i>
                        <a href="{{ route('posts.index', ['tag_name' => $tag->tag_name]) }}">
                            #{{ $tag->tag_name }}
                        </a>
                    @else
                    @endif
                @endforeach
            </h5>
            <!-- スレッド詳細 -->
            <a href="{{ route('posts.show' ,$post->id)}}" class="btn btn-primary">スレッド詳細</a>

            
            <div class="row justify-content-center">
                        <like-component
                            :post="{{ json_encode($post)}}"></like-component>
            </div>

            <div style = "display: flex; word-wrap: break-word;">
            <!-- 投稿日時 -->
                <p>投稿日時：{{$post->created_at}}</p>
            <!-- お気に入りボタン -->
                <div style = "flex-direction: column; margin-left: auto;">
                    <div >
                        @if($post->is_faved_by_auth_user())
                            <a href="{{ route('post.unfav', ['id' => $post->id]) }}"><i class="fas fa-star"></i></a>
                        @else
                            <a href="{{ route('post.fav', ['id' => $post->id]) }}"><i class="far fa-star"></i></a>
                        @endif
                    </div>
                </div>
            </div>
            
            <hr>
        </div>
    </div>
    @endforeach
         <!-- {{-- @if(isset($category_id))
              {{ $posts->appends(['category_id' => $category_id])->links() }} 
              @elseif(isset($tag_name)) --}}  -->

              

    @if(isset($tag_name))
    {{ $posts->appends(['tag_name' => $tag_name])->links() }}

    @elseif(isset($search_query))
    {{ $posts->appends(['search' => $search_query])->links() }}

    @else
    {{ $posts->links() }} <!-- ページネーション -->
    @endif　


    <!-- モーダル用 -->
    @guest
    @else
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
                                投稿
                                <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">×</span>
                                <span class="sr-only">閉じる</span>
                                </button>
                            </div>

                            <form role="form"id="form1"action="{{ route('posts.store')}}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <!-- Modal ボディー -->
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="title">title</label>
                                        <input id="title" type="text" class="form-control"  placeholder="title" name="title" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="image">picture
                                            <i class="far fa-image"></i>
                                        </label>
                                            <input type="file" class="form-control-file" id="image" name="image" >
                                    </div>

                                    <div class="form-group">
                                            <label for="comment">Comment</label>
                                            <textarea class="form-control" rows="5" id="comment" name="content"></textarea>
                                    </div>

                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                </div>
                                <!-- Modal フッター -->
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

</div>
@endsection
