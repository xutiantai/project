<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/27
 * Time: 21:57
 */

namespace app\index\controller;


use think\Controller;

class Error extends Controller
{
    public  function _empty(){
        return $this->error("404异次元", 'index/index');
    }
}