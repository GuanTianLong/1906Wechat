<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Wechat;
use App\Tools\Curl;
use App\Model\Material;
class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *素材展示
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //分页
        $pageSize = config('app.pageSize');
        $materialInfo = Material::paginate($pageSize);
        //dd($materialInfo);
        return view('admin.material.index',['materialInfo'=>$materialInfo]);
    }

    /**
     * Show the form for creating a new resource.
     *素材添加
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.material.create');
    }

    /**
     * Store a newly created resource in storage.
     *执行素材添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //1.接值
        $dataAll = $request->input();
        //dd($dataAll);

        //2.laravel框架文件上传
        $file = $request->file;
        //echo $file;

        //判断是否有文件上传
        if (!$request->hasFile('file')) {
            echo "错误";
        }
        //得到文件后缀名
        $fileSuffix = $file->getClientOriginalExtension();
        //拼接上文件后缀名
        $fielName = md5(uniqid()).".".$fileSuffix;

        //store 方法接受相对于文件系统配置的存储文件根目录的路径
        $filePath = $file->storeAs('images',$fielName);

        //var_dump($filePath);

        //3.调用微信上传素材接口 把图片=>微信服务器上
        //微信接口调用凭证
        $access_token = Wechat::getAccessToken();
        //var_dump($access_token);die;

        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$access_token."&type=".$dataAll['material_format'];

        //curl发送文件的时候需要先通过CURLFile类来处理
        $filePathObj = new \CURLFile(public_path()."/".$filePath);
        //dd($filePath);

        //post方式   获取接口参数
        $postData = ['media'=>$filePathObj];

        //发送请求
        $res = Curl::curlPost($url,$postData);
        //var_dump($res);die;

        $res = json_decode($res,'true');
        if(isset($res['media_id'])){
            $media_id = $res['media_id'];

            $data = [
                'material_name' => $dataAll['material_name'],
                'material_format' => $dataAll['material_format'],
                'material_type' => $dataAll['material_type'],
                'material_url' => $filePath,
                'wechat_media_id' => $media_id,
                'add_time' => time()
            ];
            //dd($data);

            //4.入库
            $result = Material::create($data);
            if($result){
                echo "<script>alert('素材添加成功');location.href='/material/index'</script>";
            }else{
                echo "<script>alert('素材添加失败');location.href='/material/create'</script>";
            }
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


}
