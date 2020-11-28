@extends('layouts.app')
@section('title','ユーザー情報変更')
@section('content')
<div>
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
</div>

<div class="panel-heading" style="text-align:center;">{{ $authUser->name }}さんのプロフィール
    </div>
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

        <div>
        <div style="text-align:center;">
        @if(!empty($authUser->pro_image))
        <img src="{{ asset('storage/pro_image/'.$authUser->pro_image) }}" class="pro_image" style= "width: 200px;
                height: 200px;
                background: #eee;
                border-radius: 50%;
                box-shadow: 0 2px 3px 1px rgb(0, 0, 0);
                object-fit: cover;
                ">
        @else
        プロフィール画像なし
        @endif
        </div>  


        <form method="post" action="{{ route('user.userUpdate') }}" enctype="multipart/form-data">
        {{ csrf_field() }}

            <input type="hidden" name="password" value="{{ $authUser->password }}">
            <div class="form-group">
                <input type="hidden" name="user_id" value="{{ $authUser->id }}">
                @if($errors->has('user_id'))<div class="error">{{ $errors->first('user_id') }}</div>@endif
            </div>


            <div class="form-group"><p>プロフィール写真<i class="far fa-image"></i></p>
                <input type="file" name="pro_image">
            </div>

            <div class="form-group">
                <p>User ID</p><input type="text" name="unique_id" value="{{ $authUser->unique_id }}">
            </div>

            <div class="form-group">
                <p>email</p><input type="email" name="email" value="{{ $authUser->email }}">
            </div>

            <div class="form-group">
            <p>user name</p><input type="text" class="userForm" name="name" placeholder="User" value="{{ $authUser->name }}">
                @if($errors->has('name'))<div class="error">{{ $errors->first('name') }}</div>@endif
            </div>

            <div class="form-group">
            <p>自己紹介</p>
                  <textarea class="form-control" rows="5" name="self" placeholder="自己紹介" value="{{ $authUser->self }}">{{ $authUser->self }}</textarea>
            </div>

            <div class="buttonSet">
            <input type="submit" name="send" value="プロフィール変更" class="btn btn-primary btn-sm btn-done">
            <a href="{{ route('user.index') }}" class="btn btn-primary btn-sm">戻る</a>
            </div>
            
        </form>

        </div>
    </div>
</div>


 

@endsection