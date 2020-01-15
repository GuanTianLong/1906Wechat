@extends('layouts.app')

@section('title', '渠道添加')

@section('content')
    <h3 align="center" style="color:red">❤❤<b style="color:black">渠道添加</b>❤❤</h3><hr>

    <form class="form-horizontal" role="form" action="{{url('/channel/store')}}" method="post" enctype="multipart/form-data">
        <div class="form-group has-success">
            <label class="col-sm-2 control-label">渠道名称：</label>
            <div class="col-sm-5">
                <input class="form-control" id="focusedInput" type="text" name="channel_name" placeholder="请输入渠道名称...">
            </div>
        </div>
        <div class="form-group has-warning">
            <label class="col-sm-2 control-label" for="inputSuccess">
                渠道标识：
            </label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="inputSuccess" name="channel_status" placeholder="请输入渠道标识...">
            </div>
        </div>
        <div class="form-group has-success">
            <label class="col-sm-2 control-label">所花费用：</label>
            <div class="col-sm-5">
                <input class="form-control" id="focusedInput" type="text" name="channel_price" placeholder="请输入所花费用...">
            </div>
        </div>
        <div>
            <label class="col-sm-2 control-label" for="inputError"></label>
            <button class="btn btn-success">渠道添加</button>
        </div>
    </form>

@endsection
