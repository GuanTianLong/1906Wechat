@extends('layouts.app')

@section('title', '新闻展示')

@section('content')


	<h3 align="center" style="color:red">❤❤<b style="color:black">新闻展示</b>❤❤</h3><hr>

<form action="" method="get" align="center">
	<input type="text" id="inputSuccess" name="news_title" value="{{$query['news_title']??''}}" placeholder="请输入新闻标题...">
	<input type="text" id="inputSuccess" name="news_author" value="{{$query['news_author']??''}}" placeholder="请输入新闻作者...">
	<button class="btn btn-info">搜索</button>
</form><br>


<table class="table table-hover">

	<thead>
	<tr>
		<th>新闻编号</th>
		<th>新闻标题</th>
		<th>新闻作者</th>
		<th>添加时间</th>
		<th>新闻内容</th>
		<th>操作</th>
	</tr>
	</thead>
	<tbody>
	@foreach($newsInfo as $v)
		<tr>
			<td>{{$v->news_id}}</td>
			<td>{{$v->news_title}}</td>
			<td>{{$v->news_author}}</td>
			<td>{{date('Y-m-d h:i:s'),$v->add_time}}</td>
			<td>{{$v->news_content}}</td>
			<td>
				<a href="{{url('/news/destroy/'.$v->news_id)}}"><button type="button" class="btn btn-danger">删除</button></a>
				<a href="{{url('/news/edit/'.$v->news_id)}}"><button class="btn btn-info">编辑</button></a>
			</td>
		</tr>
	@endforeach
	</tbody>
	<tr><td colspan="6">{{$newsInfo->appends($query)->links()}}</td></tr>
</table>

@endsection