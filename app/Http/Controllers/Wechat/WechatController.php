<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Tools\Curl;
use DemeterChain\C;
use Illuminate\Http\Request;
use App\Tools\Wechat;
use App\Model\News;
use App\Model\Material;
use App\Model\Channel;
use App\Model\Wechatuser;
class WechatController extends Controller
{

    private $student = ["张世伟", "孙昱松", "黄一帆", "刘轩", "关天龙", "高伟涛", "杨晓东", "张玉磊"];


    public function wechat(Request $request)
    {
      $echostr = $_GET["echostr"];
        echo $echostr;die;
//////        echo 123;die;
//      echo request()->echostr;die;

        //接收xml数据，接入完整之后，微信公众号里的任何操作  微信服务器=>POST形式XML格式  发送到配置的url上
        $xml = file_get_contents("php://input");        //接收原始XML或json数据流
        //写入文件里
        file_put_contents("log2.txt", "\n" . $xml, FILE_APPEND);
        //方便处理xml=>对象
        $xmlobj = simplexml_load_string($xml);

        //如果是关注
        if ($xmlobj->MsgType == 'event' && $xmlobj->Event == 'subscribe') {
            //echo "1";die;

            //关注时获取用户基本信息
            //获取sccess_token(微信接口调用凭证)
            //$access_token = Wechat::getAccessToken();
            //$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$xmlobj->FromUserName."&lang=zh_CN";
            //获取文件
            //$data = file_get_contents($url);
            //$data = json_decode($data,true);

            //获取用户基本信息
            $data = Wechat::getUserInfoByOpenId($xmlobj->FromUserName);
            //dd($data);

            //得到渠道的标识
            $channel_status = $data['qr_scene_str'];

            //得到openid
            $openid = $data['openid'];
            //dd($openid);

            //根据渠道标识，关注人数递增
            Channel::where(['channel_status'=>$channel_status])->increment('attention_number');

            //判断用户基本信息表有没有数据
            //如果有---------根据openid查询用户基本信息表的一条数据，如果查询到对应的用户，修改此用户的状态即可
            $count = Wechatuser::where(['openid'=>$openid])->count();
            //dd($userInfo);

            if($count>0){
                Wechatuser::where(['openid'=>$openid])->update(['is_sub'=>1,'channel_status'=>$channel_status]);

            }else{
                //如果没有---------存储用户关注时的信息即可
                Wechatuser::create([
                    'openid' => $data['openid'],
                    'nickname' => $data['nickname'],
                    'sex' => $data['sex'],
                    'province' => $data['province'],
                    'city' => $data['city'],
                    'channel_status' => $data['qr_scene_str'],
                ]);

                //获取用户昵称
                $nickname = $data['nickname'];
                //echo $nickname;die;
                //获取用户性别
                $sex = $data['sex'];
                if($sex=='1'){
                    $sex = '先生';
                }else if($sex=='2'){
                    $sex = '女士';
                }else{
                    $sex = '未知';
                }
                //echo $sex;die;
                Wechat::reponseText($xmlobj, "欢迎".$nickname.$sex."关注");
            }
        }

        //如果是取消关注(取关)
        if($xmlobj->MsgType == 'event' && $xmlobj->Event == 'unsubscribe'){

            //获取用户基本信息
            $data = Wechat::getUserInfoByOpenId($xmlobj->FromUserName);

            //取出openid
            $openid = $data['openid'];
            //dd($openid);

            //根据openid查询用户基本信息表的的数据
            $res = Wechatuser::where(['openid'=>$openid])->first();
            //dd($res);

            //获取到渠道标识
            $channel_status =  $res['channel_status'];
            //dd($channel_status);

            //根据渠道标识，关注人数递减
            $data = Channel::where(['channel_status'=>$channel_status])->decrement('attention_number');
            //dd($data);

            //根据openid修改用户基本信息表的用户状态(1:关注  2:取消关注)
            Wechatuser::where(['openid'=>$openid])->update(['is_sub'=>2]);

        }

        //如果是用户发送文本消息
        if ($xmlobj->MsgType == 'text') {
            //取出文本内容两边的空格
            $content = trim($xmlobj->Content);

            $student= implode(",", $this->student);

            if ($content == '1') {
                //var_dump($students);die;
                //回复全寝室人的名字
                Wechat::reponseText($xmlobj, $student);
            } else if ($content == '2') {
                shuffle($this->student);
                $students = $this->student[0];
                Wechat::reponseText($xmlobj, $students);
            } else if (mb_strpos($content, "天气") !== false) {     //城市名字+天气
                //回复天气
                $city = rtrim($content, "天气");
                //var_dump($city);die;
                if (empty($city)) {
                    $city = "北京";
                }
                //天气接口
                $url = "http://api.k780.com:88/?app=weather.future&weaid=" . $city . "&&appkey=47874&sign=bdf2e221639fbdd9357c3552af5e7faf&format=json";

                $data = file_get_contents($url);

                $data = json_decode($data, true);

                //var_dump($data);die;

                $msg = "";

                foreach ($data['result'] as $key => $val) {

                    $msg .= $val['days'] . " " . $val['week'] . " " . $val['citynm'] . " " . $val['temperature'] . " " . $val['weather'] . "\n";
                }

                Wechat::reponseText($xmlobj, $msg);
            }

            //如果用户发送新闻+关键字-----回复此新闻内容
            if(mb_strpos($content,"新闻+") !==false){       //新闻+新闻关键字
                //echo 1;die;

                $keyword = mb_substr($content,3);
                //dd($keyword);

                $data = News::where('news_title','like',"%$keyword%")->first()->toArray();
                //var_dump($data);die;

                Wechat::reponseText($xmlobj, $data['news_content']);
            }else{
                $msg = "暂无相关新闻";
                Wechat::reponseText($xmlobj,$msg);
            }

            //如果用户发送最新新闻-----回复最新新闻内容
            if($content == '最新新闻'){
                $res = News::orderBy('news_id','desc')->limit(1)->first()->toArray();
                //$data = json_decode($res, true);
                //dd($data);

                Wechat::reponseText($xmlobj, $res['news_content']);
            }
        }
    }

    /**根据openid群发*/
    public function sendAllByOpenId(){
        //查询用户表的信息----根据openid
        $userInfo = Wechatuser::select('openid')->get()->toArray();
        //echo "<pre>";print_r($userInfo);echo "</pre>";die;

        //openid 列表 可以从数据库获取
        $openid_list = array_column($userInfo,'openid');
        //echo "<pre>";print_r($openid_list);echo "</pre>";die;

        $msg = date('Y-m-d H:i:s').",在这里提前祝大家新年快乐！";

        echo "消息".$msg;echo"<br>";

        $json_data = [
            "touser" => $openid_list,
            "msgtype" => "text",
            "text" => [
                "content" => $msg
            ]
        ];
        //echo "<pre>";print_r($json_data);echo "</pre>";die;

        //获取access_token
        $access_token = Wechat::getAccessToken();
        //调用根据openid列表群发的接口
        $url = "https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=".$access_token;
        //echo $url;die;

        //数据转化
        $json_datas = json_encode($json_data,JSON_UNESCAPED_UNICODE);
        //echo "<pre>";print_r($result);echo "</pre>";die;

        //POST请求
        $result = Curl::curlPost($url,$json_datas);
        //echo "<pre>";print_r($result);echo "</pre>";die;

        //检查错误
        if($result['errcode']>0){
            echo "错误信息：".$result['errmsg'];
        }else{
            echo "发送成功";
        }

    }

}
?>

