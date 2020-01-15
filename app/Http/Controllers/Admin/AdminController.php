<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //phpinfo
    public function test(){

        echo phpinfo();
    }

    //后台首页
    public function index()
    {

        return view('admin.admin.index');
    }

    //后台主页
    public function home(){

        return view('admin.admin.home');
    }

    //获取天气信息
    public function getWeather(Request $request){

        //接收ajax请求传过来的城市名称
        $city = $request->city;
        //dd($city);

        //调用天气接口----获取天气数据信息
        $url = "http://api.k780.com:88/?app=weather.future&weaid=" . $city . "&&appkey=47874&sign=bdf2e221639fbdd9357c3552af5e7faf&format=json";
        //dd($url);

        $data = file_get_contents($url);
        //dd($data);

        $data = json_decode($data,true);
        //dd($data);

        //将转化后的天气数据信息返回

        return $data;
    }
}
