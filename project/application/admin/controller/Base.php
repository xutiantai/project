<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/26
 * Time: 12:57
 */

namespace app\admin\controller;
use think\Controller;

class Base extends  Controller
{
    protected function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->islogin();
    }
    /*
     *管理员登陆
     */

    /**
     *Base类初始化调用，判断用户是否登陆，若登陆则跳转到主页，未登录，不可访问Admin控制器
     */
    public function _empty(){
        $this->error("页面未找到，即将跳转主页", 'admin/lst');
    }
    public function islogin()
    {
        $logstate=session('admin');
        if (isset($logstate) &&session('admin')) {

        }else{
            $this->error("请登录", 'login/loginlst');
        }

    }
}