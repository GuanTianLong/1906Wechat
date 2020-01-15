@extends('layouts.app')

@section('title', '素材添加')

@section('content')
    <h3 align="center" style="color:red">❤❤<b style="color:black">素材添加</b>❤❤</h3><hr>

    <form class="form-horizontal" role="form" action="{{url('/material/store')}}" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label class="col-sm-2 control-label">素材名称：</label>
            <div class="col-sm-5">
                <input class="form-control" id="focusedInput" type="text" name="material_name" placeholder="请输入素材名称...">
            </div>
        </div>
        <div class="form-group has-success">
            <label class="col-sm-2 control-label" for="inputSuccess">
                素材文件：
            </label>
            <div class="col-sm-5">
                <input type="file" class="form-control" id="inputSuccess" name="file">
            </div>
        </div>
        <div class="form-group has-warning">
            <label class="col-sm-2 control-label" for="inputWarning">
                素材类型：
            </label>
            <div class="col-sm-5">
                <select class="form-control" name="material_type">
                    <option value="1">临时</option>
                    <option value="2">永久</option>
                </select>
            </div>
        </div>
        <div class="form-group has-success">
            <label class="col-sm-2 control-label" for="inputSuccess">
                素材格式：
            </label>
            <div class="col-sm-5">
                <select class="form-control" name="material_format">
                    <option value="image">图片</option>
                    <option value="voice">语音</option>
                    <option value="video">视频</option>
                    <option value="thumb">缩略图</option>
                </select>
            </div>
        </div>
        <div>
            <label class="col-sm-2 control-label" for="inputError"></label>
            <button class="btn btn-success">素材添加</button>
        </div>
    </form>

@endsection
