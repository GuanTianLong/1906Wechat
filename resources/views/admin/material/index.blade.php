@extends('layouts.app')

@section('title', '素材展示')

@section('content')

	<h3 align="center" style="color:red">❤❤<b style="color:black">素材展示</b>❤❤</h3><hr>

	<table class="table table-hover">
		<thead>
		<tr>
			<th>素材编号</th>
			<th>素材名称</th>
			<th>素材格式</th>
			<th>素材类型</th>
			<th>素材展示</th>
			<th>添加时间</th>
			<th>操作</th>
		</tr>
		</thead>
		<tbody>
		@foreach($materialInfo as $v)
		<tr>
			<td>{{$v->material_id}}</td>
			<td>{{$v->material_name}}</td>
			<td>
				@if($v->material_format == 'image')
					<b style="color:magenta">图片</b>
				@elseif($v->material_format == 'voice')
					<b style="color:deepskyblue">语音</b>
				@elseif($v->material_format == 'video')
					<b style="color:blue">视频</b>
				@endif
			</td>
			<td>@if($v->material_type==1)<b style="color:red">临时</b>@else<b style="color:blue">永久</b>@endif</td>
			<td>
				@if($v->material_format == 'image')
					<img src="\{{$v->material_url}}" width="150px">
				@elseif($v->material_format == 'voice')
					<audio src="\{{$v->material_url}}" controls="controls" width="200px"></audio>
				@elseif($v->material_format == 'video')
					<video src="\{{$v->material_url}}" controls="controls" width="170px"></video>
				@endif
			</td>
			<td>{{date('Y-m-d H:i:s'),$v->add_time}}</td>
			<td>
				<button type="button" class="btn btn-danger">删除</button>
				<button type="button" class="btn btn-info">编辑</button>
			</td>
		</tr>
		@endforeach
		</tbody>
		<tr><td colspan="7">{{$materialInfo->links()}}</td></tr>
	</table>

@endsection

