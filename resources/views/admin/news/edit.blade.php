<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>News--新闻编辑</title>
    <link rel="stylesheet" href="/static/admin/css/bootstrap.min.css">
    <script src="/jquery.js"></script>
    <script src="/static/admin/js/bootstrap.min.js"></script>
</head>
<body>

<a href="{{url('/news/index')}}">新闻展示</a>

<h3 align="center" style="color:red">❤❤<b style="color:black">新闻编辑</b>❤❤</h3><hr>

<form class="form-horizontal" role="form" action="{{url('/news/update/'.$newsInfo->news_id)}}" method="post">
    <div class="form-group has-success">
        <label class="col-sm-2 control-label" for="inputSuccess">
            新闻标题:
        </label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="inputSuccess" name="news_title" value="{{$newsInfo->news_title}}" placeholder="请输入新闻标题...">
        </div>
    </div>
    <div class="form-group has-success">
        <label class="col-sm-2 control-label" for="inputSuccess">
            新闻作者:
        </label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="inputSuccess" name="news_author" value="{{$newsInfo->news_author}}" placeholder="请输入新闻作者...">
        </div>
    </div>
    <div class="form-group has-success">
        <label class="col-sm-2 control-label" for="inputSuccess">
            新闻内容:
        </label>
        <div class="col-sm-4">
            <textarea class="form-control" rows="3" name="news_content" placeholder="请输入新闻内容...">{{$newsInfo->news_content}}</textarea>
        </div>
    </div>
    <div>
        <label class="col-sm-2 control-label" for="inputError"></label>

        <button class="btn btn-success">新闻编辑</button>
    </div>
</form>

</body>
</html>