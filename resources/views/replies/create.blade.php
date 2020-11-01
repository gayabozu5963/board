@extends('layouts.app')
@section('content')
<div class="panel-heading">
返信先：@
@foreach ($comments as $comment)
    {{ $comment->user->name }}
@endforeach
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
        <form action="{{ route('comments.store')}}" method="POST">
        {{ csrf_field() }}

                <div class="form-group">

                  <textarea class="form-control" rows="5" id="comment" name="comment">@ {{$comment->user->name}}さん---</textarea>
                </div>

                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <input type="hidden" name="comment_id" value="{{ $comment_id }}">

            <button type="submit" class="btn btn-primary"><i class="fas fa-reply"></i>Reply</button>
        </form>

        </div>
    </div>
</div>
@endsection
