<?php

namespace App\Tools;
use Illuminate\Support\Facades\Cache;

/**微信核心类*/
class Wechat
{
    const appId="wx13d874725b17381e";

    const appSecret="8372505d057f5dfd87ce69a0201bf3d5";
    /**回复文本消息*/
    public static function reponseText($xmlobj,$msg){
        echo
            "<xml>
                  <ToUserName><![CDATA[".$xmlobj->FromUserName."]]></ToUserName>
                  <FromUserName><![CDATA[".$xmlobj->ToUserName."]]></FromUserName>
                  <CreateTime>".time()."</CreateTime>
                  <MsgType><![CDATA[text]]></MsgType>
                  <Content><![CDATA[".$msg."]]></Content>
            </xml>";
    }

    /**获取微信接口*/
    public static function getAccessToken(){
            //先判断缓存是否有数据
            $access_token = Cache::get('access_token');
            if(empty($access_token)){
                //获取sccess_token(微信接口调用凭证)
                $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".Self::appId."&secret=".Self::appSecret;
                //获取文件
                $data = file_get_contents($url);

                $data = json_decode($data,true);

                $access_token = $data['access_token'];  //token如何存储2小时
                //echo $access_token;die;

                Cache::put('sccess_token',$access_token,7200);

            }

                //没有数据再进去调微信接口获取->存入缓存
                return $access_token;

    }

    /**获取用户基本信息*/
    public static function getUserInfoByOpenId($openid){
        //获取access_token
        $access_token = Self::getAccessToken();
        //地址
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";

        //获取文件
        $data = file_get_contents($url);

        $data = json_decode($data,true);

        return $data;
        //dd($data);



    }

    /**生成待带参数的二维码*/
    public static function createCode(){
        //获取access_token
        $access_token = Self::getAccessToken();
        //地址
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token;

        //参数
        $postData = '{"expire_seconds": 604800, "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "1907code"}}}';



    }

}
