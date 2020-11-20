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
            <!--user image -->
            @if(!empty($post->user->pro_image))
                <div style = "display: flex; word-wrap: break-word;">
                    <img src="{{ asset('storage/pro_image/'.$post->user->pro_image) }}" class="pro_image">
                    <div style = "flex-direction: column; padding-left: 10px;max-width: 80%;">
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
            <!-- 詳細 -->
            <a href="{{ route('posts.show' ,$post->id)}}" class="btn btn-primary">スレッド詳細</a>

            
            <div class="row justify-content-center">
                        <like-component
                            :post="{{ json_encode($post)}}"
                        ></like-component>
            </div>


            <h5 style= "text-align: right;">
                <div>
                    @if($post->is_faved_by_auth_user())
                        <a href="{{ route('post.unfav', ['id' => $post->id]) }}"><i class="fas fa-star"></i></a>
                    @else
                        <a href="{{ route('post.fav', ['id' => $post->id]) }}"><i class="far fa-star"></i></a>
                    @endif
                </div>
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
