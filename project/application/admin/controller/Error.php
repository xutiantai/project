<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/26
 * Time: 16:16
 */

namespace app\admin\controller;


use think\Controller;

class Error extends Controller
{

    public function _empty($name)
    {
        //把所有城市的操作解析到city方法
        return '404！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！';
    }
}