@extends('layouts.app')
@section('content')
<div class="panel-heading">MonoLog</div>
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
        <form action="{{ route('posts.store')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}

            <div class="form-group">
                <label for="exampleInputEmail1">title</label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="title" name="title" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="exampleFormControlFile1">picture
                <i class="far fa-image"></i>
                </label>
                <input type="file" class="form-control-file" id="exampleFormControlFile1" name="image" accept='image/*' onchange="previewImage1(this);">
            </div>
            <canvas class="preview" id="preview1"></canvas>

            <div class="form-group">
                <label for="comment">Comment</label>
                <textarea class="form-control" rows="5" id="comment" name="content"></textarea>
            </div> 

            <!-- 問題フォーム -->
            <hr>
            <div>
                <u><h4>QuestionNo,１</h4></u><br/>
                <div class="form-group">
                    <label>Question sentence</label>
                    <input type="text" class="form-control question_text" id="" placeholder="Answer" name="title" autocomplete="off"><br/>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">QuestionPicture
                        <i class="far fa-image"></i>
                        </label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1" name="image"　accept='image/*' onchange="previewImage2(this);">
                    </div>
                    <canvas class="preview" id="preview2"></canvas>
                </div><br/>
                <div class="form-group">
                    <label>Answer Type</label>
                    <div class="tab-wrap">
                        <input id="TAB-01" type="radio" name="answerType" class="tab-switch" checked="checked" value="text"/><label class="tab-label" for="TAB-01">text</label>
                            <div class="tab-content">
                                <textarea class="form-control question_text" rows="5" id="comment" name="content"　placeholder="Answer"></textarea>
                            </div>
                        <input id="TAB-02" type="radio" name="answerType" class="tab-switch" value="choices"/><label class="tab-label" for="TAB-02">4 choices</label>
                            <div class="tab-content">
                                <div class="ans_choices">
                                    <p>Randomly select an to one of the following four choices.<br/>
                                    Write the correct answer on the checked number.Other than that, dummy.</p>
                                    <input type="radio" class="" id="" placeholder="title" name="4choices" value="1">　1st choice<br/>
                                        <input type="text" class="form-control" id="" placeholder="1st choice answer" name="text"  autocomplete="off"><br/>
                                    <input type="radio" class="" id="" placeholder="title" name="4choices" value="2">　2nd choice<br/>
                                        <input type="text" class="form-control" id="" placeholder="2nd choice answer"  autocomplete="off"><br/>
                                    <input type="radio" class="" id="" placeholder="title" name="4choices" value="3">　3rd choice<br/>
                                        <input type="text" class="form-control" id="" placeholder="3rd choice answer"  autocomplete="off"><br/>
                                    <input type="radio" class="" id="" placeholder="title" name="4choices" value="4">　4th choice<br/>
                                        <input type="text" class="form-control" id="" placeholder="4th choice answer"  autocomplete="off"><br/>
                                </div>
                            </div>
                     </div>
                </div>
            </div>

            <input type="hidden" name="user_id" value="{{ Auth::id() }}">

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        </div>
    </div>
</div>
</div> 

@endsection
