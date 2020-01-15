<?php

namespace App\Http\Controllers\Git;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GitpullController extends Controller
{

    public function pull(){

        $cmd = "cd /data/wwwroot/default/1907wechat&&git pull";
        shell_exec($cmd);
    }

}
