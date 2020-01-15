@extends('layouts.app')

@section('title', '新闻添加')

@section('content')

<h3 align="center" style="color:red">❤❤<b style="color:black">新闻添加</b>❤❤</h3><hr>

<form class="form-horizontal" role="form" action="{{url('/news/store')}}" method="post">
    <div class="form-group">
        <label class="col-sm-2 control-label" for="inputSuccess">
            新闻标题:
        </label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="focusedInput" name="news_title" placeholder="请输入新闻标题...">
        </div>
    </div>
    <div class="form-group has-success">
        <label class="col-sm-2 control-label" for="inputSuccess">
            新闻作者:
        </label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="inputSuccess" name="news_author" placeholder="请输入新闻作者...">
        </div>
    </div>
    <div class="form-group has-warning">
        <label class="col-sm-2 control-label" for="inputSuccess">
            新闻内容:
        </label>
        <div class="col-sm-4">
            <textarea class="form-control" rows="3" name="news_content" placeholder="请输入新闻内容..."></textarea>
        </div>
    </div>
    <div>
        <label class="col-sm-2 control-label" for="inputError"></label>

        <button class="btn btn-success">新闻添加</button>
    </div>
</form>

@endsection