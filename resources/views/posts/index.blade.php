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
                                        <input type="text" class="form-control"　placeholder="search" name="search" value="">
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
                        font-weight: 600;">
                            Title： {{ $post->title }}
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
                        font-weight: 600;">
                            Title： {{ $post->title }}
                        </p>
                    </div>
            </div>
            @endif
            
            <!-- カテゴリー -->
            <!-- {{-- <p>
            Category ： 
                <a href="{{ route('posts.index', ['category_id' => $post->category_id]) }}">
                    {{ $post->category->category_name }}
                </a>
            </p> --}}-->

            <!-- image -->
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
            
            <!-- tag -->
            <h5 class="card-title">
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
            <!-- 詳細 -->
            <a href="{{ route('posts.show' ,$post->id)}}" class="btn btn-primary">スレッド詳細</a>
            <h5 class="card-title"style= "text-align: right;">
            <i class="far fa-star"></i>
            </h5>
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
</div>
@endsection
