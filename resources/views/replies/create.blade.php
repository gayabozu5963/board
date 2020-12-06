@extends('layouts.app')
@section('content')
<div class="panel-heading">

@if(!isset($replies[0]))
@foreach ($comments as $comment)
返信先：@ {{ $comment->user->name }}
@endforeach
@else
@foreach ($comments as $comment)
返信先：@ {{ $comment->user->name }}
@endforeach
@ {{ $replies[0]->user->name }}
@endif
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
        @if(!isset($replies[0]))
        <form action="{{ route('replies.store')}}" method="POST">
        {{ csrf_field() }}
                <div class="form-group">
                  <textarea class="form-control" rows="5" id="replie" name="replie">@ {{$comment->user->unique_id}}さん>>></textarea>
                </div>

                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <input type="hidden" name="comment_id" value="{{ $comment_id }}">
                <input type="hidden" name="post_id" value="{{ $post_id }}">

            <button type="submit" class="btn btn-primary"><i class="fas fa-reply"></i>Reply</button>
        </form>
        @else
        <form action="{{ route('replies.store')}}" method="POST">
        {{ csrf_field() }}
                <div class="form-group">
                @foreach ($comments as $comment)
                @foreach ($replies as $replie)
                <textarea class="form-control" rows="5" id="replie" name="replie">@ {{$comment->user->unique_id}}さん>>>@ {{$replie->user->unique_id}}さん>>></textarea>
                @endforeach
                @endforeach
                </div>

                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <input type="hidden" name="comment_id" value="{{ $comment_id }}">
                <input type="hidden" name="post_id" value="{{ $post_id }}">
                <input type="hidden" name="repliereplie_id" value="{{ $replies[0]->id }}">

            <button type="submit" class="btn btn-primary"><i class="fas fa-reply"></i>Reply</button>
        </form>
        @endif

        </div>
    </div>
</div>
@endsection
