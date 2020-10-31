@extends('layouts.app')
@section('content')
<div class="panel-heading">{{ $user->name }}の投稿
</div>


<!-- <div class="card-header">{{ $user->name }}の投稿</div> -->
<div class="panel-body">
            

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
                <h5 class="card-title">
                    カテゴリー:
                        <a href="{{ route('posts.index', ['category_id' => $post->category_id]) }}">
                        {{ $post->category->category_name }}
                    </a>
                </h5>

                <p class="card-text">{{ $post->content }}</p>

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
          </div>
          <br>
          <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">詳細</a>
        </div>
        <hr>
    @endforeach

    
</div>
@endsection