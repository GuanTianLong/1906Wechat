<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Wechat;
use App\Tools\Curl;
class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *创建菜单
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createMenu()
    {

        //获取access_token
        $access_token = Wechat::getAccessToken();
        //echo $access_token;

        //调用菜单接口
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        //echo $url;

        $menu = [
            "button"=>[
                [
                    "name"=>"今日歌曲",
                    "type"=>"click",
                    "key"=>"V1001_TODAY_MUSIC"
                ],
                [
                    "name"=>"菜单栏",
                    "sub_button"=>[
                        [
                            "name"=>"扫一扫",
                            "type"=>"scancode_waitmsg",
                            "key"=>"rselfmenu_0_0"
                        ],
                        [
                            "name"=>"拍照或者相册发送",
                            "type"=>"pic_photo_or_album",
                            "key"=>"rselfmenu_1_1"
                        ],
                        [
                            "name"=>"腾讯网",
                            "type"=>"view",
                            "url"=>"https://www.qq.com/"
                        ]
                    ]
                ],
            ]

        ];
        //要发送的数据
        $dataString = json_encode($menu,JSON_UNESCAPED_UNICODE);
        //dd($dataString);

        //发送请求
        $res = Curl::curlPost($url,$dataString);
        var_dump($res);
    }

}
