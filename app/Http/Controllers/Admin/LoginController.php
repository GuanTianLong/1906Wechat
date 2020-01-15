<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Login;

class LoginController extends Controller
{
    //登录
    public function login(){

        return view('admin.login.login');
    }

    //执行登录
    public function loginDo()
    {

        //$data = request()->except('_token');
        $account = request()->account;
        $pwd = request()->pwd;

        $where = [
            ['account', '=', $account],
            ['pwd', '=', $pwd]
        ];

        $first = Login::where($where)->first();
        //dd($first);
        if (!empty($first)) {

            $error_num = $first['error_num'];

            $last_error_time = $first['last_error_tiem'];

            $login_id = $first['login_id'];

            $time = time();

            if($first['pwd']==$pwd){
                //密码正确
                if($error_num>=3&&($time-$last_error_time)<3600){
                    $min = 60-ceil(($time-$last_error_time)/60);
                    echo "账号已锁定，请于".$min."分钟后登录";die;
                    //return redirect('/admin/index')->with('msg',"账号已锁定，请于".$min."分钟后登录");die;

                }

                //清零  错误时间改为null
                $res = Login::where('login_id','=',$login_id)->update(['error_num'=>0,'last_error_time'=>null]);

                echo "<script>alert('登录成功');location.href='/admin/index'</script>";
            }else{
                //密码错误
                if(($time-$last_error_time)>3600){
                    //错误次数改为1，错误时间改为当前时间
                    $res = Login::where('login_id','=',$login_id)->update(['error_num'=>1,'last_error_time'=>time()]);
                    //dd($res);
                    if($res){
                        echo "密码错误，还有2次机会";die;
                    }
                }

                if($error_num>=3){

                    $min = 60-ceil(($time-$last_error_time)/60);

                    echo "账号已锁定，请于".$min."分钟后登录";die;

                }else{

                    $res = Login::where('user_id','=',$login_id)
                        ->update(['error_num'=>$error_num+1,'last_error_time'=>$time]);
                   //dd($res);
                    if($res){
                        echo "密码错误,还有".(3-($error_num+1))."次机会";die;
                    }

                }
            }
        }else{

            echo "<script>alert('账号有误');location.href='/login/login'</script>";
        }

    }

}
