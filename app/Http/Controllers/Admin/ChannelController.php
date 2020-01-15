<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Channel;
use App\Tools\Wechat;
use App\Tools\Curl;
class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *渠道展示
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //分页
        $pageSize = config('app.pageSize');
        $channelInfo = Channel::orderBy('channel_id','desc')->paginate($pageSize);

        //dd($channelInfo);

        return view('admin.channel.index',['channelInfo'=>$channelInfo]);
    }

    /**
     * Show the form for creating a new resource.
     *渠道添加
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.channel.create');
    }

    /**
     * Store a newly created resource in storage.
     *执行渠道添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $channel_name = $request->channel_name;
        $channel_status = $request->channel_status;
        $channel_price = $request->channel_price;
        //dd($data);

        //获取access_token
        $access_token = Wechat::getAccessToken();
        //echo $access_token;die;

        //地址
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token;

        //参数
        // $postData = '{"expire_seconds": 2592000, "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "'.$channel_status.'"}}}';
        //var_dump($postData);die;

        $postData = [
            'expire_seconds' => 2592000,
            'action_name' => 'QR_STR_SCENE',
            'action_info' => [
                'scene' => [
                    'scene_str' => $channel_status
                ],
            ],
        ];

        $postData = json_encode($postData,JSON_PRESERVE_ZERO_FRACTION );
        //var_dump($postData);die;
        //请求方式
        $res = Curl::curlPost($url,$postData);
        //var_dump($res);die;

        $res = json_decode($res,'true');
        //var_dump($res);die;

        //第一种方式-----存入全路径
        $ticket = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$res['ticket'];

        //第二种方式----只存入ticket
        //$ticket = $res['ticket'];

        $data = [
            'channel_name' => $channel_name,
            'channel_status' => $channel_status,
            'channel_price' => $channel_price,
            'ticket' => $ticket
        ];
        //dd($data);die;

        $result = Channel::create($data);
        if($result){
            echo "<script>alert('渠道添加成功');location.href='/channel/index'</script>";
        }else{
            echo "<script>alert('渠道添加失败');location.href='/channel/create'</script>";
        }

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
     *渠道编辑
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *执行渠道编辑
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
     *渠道删除
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *生成带参数的二维码(临时二维码)
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createCode()
    {

        //获取token
        $access_token ='29_vKuAJRpBx4fYcu4xa0lo004MwVcuNyC5XxaakzgOZVg2CbIoynFz0zS3AU6ZZCCiPtVJRR6w7xvZ-J53PA_ycRwvL6M3bixjNpl2e311yuSqaM92PAktFYil6O3_Rnl8vjcib_KBKXG_-AcWPOEgAJAIHX';
        //地址
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token;
        //dd($url);
        //参数
        $postData = '{"expire_seconds": 604800, "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "1907code"}}}';
        //var_dump($postData);die;
        //请求方式
        $res = Curl::curlPost($url,$postData);
        var_dump($res);die;
    }


    /**
     * Remove the specified resource from storage.
     *渠道统计图表
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function statistical()
    {
//        //查询渠道表的所有数据------作为渠道图表统计的展示
        $channelInfo = Channel::get()->toArray();
        //var_dump($channelInfo);die;
        $xStr = "";
        $yStr = "";
        foreach($channelInfo as $v){
            $xStr .= '"'.$v['channel_name'].'",';
            $yStr .= $v['attention_number'].',';
        }
        //dd($xStr);

        //去除渠道名称右边的，
        $xStr = rtrim($xStr,',');
        //dd($xStr);

        //去除渠道关注人数右边的，
        $yStr = rtrim($yStr,',');
        //dd($yStr);

        return view('admin.channel.statistical',['xStr'=>$xStr,'yStr'=>$yStr]);
		
    }


}
