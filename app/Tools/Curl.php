<?php

namespace App\Tools;

class Curl
{

//发送HTTP请求方式  file_get_contents curl

//curl
//概念？？  发送请求的扩展库 HTTP
//
//如何使用
//
//4步骤
//初始化
// $ch = curl_init();
// //设置
// curl_setopt($ch, option, value);
// //执行
// $content = curl_exec($ch);
// //关闭
// curl_close($ch);
//

    /**CURL   GET请求*/
    public static function curlGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url); //设置请求地址
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 返回数据格式
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//关闭https验证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);//关闭https验证
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /**CURL   POST请求*/
    public static function curlPost($url,$postData)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url); //设置请求地址
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 返回数据格式
        curl_setopt($curl, CURLOPT_POST, 1);  //设置以post发送
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);   //设置post发送的数据
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //关闭https验证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);//关闭https验证
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

//调用get示例
//$url = "https://www.yingge.fun/";
//$data = curlGet($url);
//调用post示例

//curlPost(请求地址,传递的数据)


}
