@extends('layouts.app')
@section('content')
<div class="panel-heading">{{ $user->name }}{{ $user->id }}{{ $user->email }}のプロフィール
    <a href="{{ route('users.edit', $user ) }}">プロフィール編集</a>
</div>

<div class="panel-body">
    <!-- tabのcssのクラス -->
    <div class="tab-wrap">
        <input id="TAB-01" type="radio" name="TAB" class="tab-switch" checked="checked" /><label class="tab-label" for="TAB-01">{{ $user->name }}の投稿</label>
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