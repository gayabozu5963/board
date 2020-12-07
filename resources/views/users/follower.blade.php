@extends('layouts.app')
@section('title','ユーザー情報')
@section('content')
<div class="panel-heading">
@foreach ($user_j as $user_i)
{{$user_i->name}}さんがフォローされているユーザ
@endforeach
</div>
        <div class="panel-body">
                @foreach ($follower as $user)
                    <div class="card">
                        <div class="card-body">
                            <div style = "display: flex; word-wrap: break-word;">
                                <div style = "flex-direction: column; padding-left: 10px;max-width: 80%;">
                                        @if(!empty($user->pro_image))
                                        <img src="{{ asset('storage/pro_image/'.$user->pro_image) }}" class="pro_image">
                                        @else
                                        <img src="{{ asset('image/noimage.png') }}" class="pro_image">
                                        @endif
                                </div>
                                <div style = "flex-direction: column; padding-left: 10px;max-width: 80%;">
                                    <a href="{{ route('users.show', $user->id) }}">
                                        {{ $user->name }}
                                    </a>
                                        @if (auth()->user()->isFollowed($user->id))
                                            <div class="px-2">
                                                <span class="px-1 bg-secondary text-light">フォローされています</span>
                                            </div>
                                        @endif
                                </div>
                                @if($user == auth()->user())
                                @else
                                <div style = "flex-direction: column;margin-left: auto;">
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
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
                <div class="my-4 d-flex justify-content-center">
                </div>
</div>

@endsection