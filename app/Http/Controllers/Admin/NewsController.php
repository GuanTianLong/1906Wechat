<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\News;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *新闻展示
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news_title = Request()->news_title;

        $news_author = Request()->news_author;

        $where = [];

        if($news_title){
            $where[] = ['news_title','like',"%$news_title%"];
        }

        if($news_author){
            $where[] = ['news_author','like',"%$news_author%"];
        }

        $pageSize = config('app.pageSize');
        $query = Request()->all();
        $newsInfo = News::where($where)->orderBy('news_id','desc')->paginate($pageSize);
        return view('admin.news.index',['newsInfo'=>$newsInfo,'query'=>$query]);
    }

    /**
     * Show the form for creating a new resource.
     *新闻添加
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *执行新闻添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->input();
        //添加时间
        $data['add_time'] = time();
        //dd($data);
        //入库
        $res = News::create($data);
        if($res){
            echo "<script>alert('新闻添加成功');location.href='/news/index'</script>";
        }else{
            echo "<script>alert('新闻添加失败');location.href='/news/create'</script>";
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
        //echo $id;die;
        $newsInfo = News::where('news_id','=',$id)->first();
        //dd($newsInfo);
        return view('admin.news.edit',['newsInfo'=>$newsInfo]);
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

        $data = $request->input();

        $data['add_time'] = time();
        //dd($data);
        $where = [
            ['news_id','=',$id]
        ];

        $res = News::where($where)->update($data);
        if($res){
            echo "<script>alert('新闻编辑成功');location.href='/news/index'</script>";
        }else{
            echo "<script>alert('新闻编辑失败');location.href='/news/edit'</script>";
        }
    }

    /**
     * Remove the specified resource from storage.
     *新闻删除
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //echo $id;
        $res = News::destroy($id);
        if($res){
            echo "<script>alert('新闻删除成功');location.href='/news/index'</script>";
        }else{
            echo "<script>alert('新闻删除失败');location.href='/news/index'</script>";
        }
    }
}
