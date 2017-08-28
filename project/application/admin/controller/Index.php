<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/26
 * Time: 10:35
 */

namespace app\admin\controller;
use think\Controller;
/*后台主页显示控制器*/
 class Index extends  Base
{
    /**
     *后台主页
     */
    public function index()
    {
        return $this->fetch();
    }




}