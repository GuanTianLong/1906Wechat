@extends('layouts.app')

@section('title', '渠道展示')

@section('content')

	<h3 align="center" style="color:red">❤❤<b style="color:black">渠道展示</b>❤❤</h3><hr>

	<table class="table table-hover">
		<thead>
		<tr>
			<th>渠道编号</th>
			<th>渠道名称</th>
			<th>素材标识</th>
			<th>渠道二维码</th>
			<th>所花费用</th>
			<th>关注人数</th>
			<th>操作</th>
		</tr>
		</thead>
		<tbody>
		@foreach($channelInfo as $v)
			<tr>
				<td>{{$v->channel_id}}</td>
				<td>{{$v->channel_name}}</td>
				<td>{{$v->channel_status}}</td>
				<td><img src="{{$v->ticket}}" alt="" width="80px"></td>
				<td>{{$v->channel_price}}</td>
				<td>@if($v->attention_number==0)<b style="color:red">暂无关注</b>@else<b style="color:blue">{{$v->attention_number}}</b>@endif</td>
				<td>
					<button type="button" class="btn btn-danger">删除</button>
					<button type="button" class="btn btn-info">编辑</button>
				</td>
			</tr>
		@endforeach
		</tbody>
		<tr><td colspan="7">{{$channelInfo->links()}}</td></tr>
	</table>

@endsection

