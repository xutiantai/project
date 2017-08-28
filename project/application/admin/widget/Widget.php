<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/26
 * Time: 11:09
 */

namespace app\admin\widget;
use think\Controller;
class Widget extends  Controller
{
    public function left ()
    {
        return $this->fetch("common/left");
    }
    public function top ()

    {
        $this->assign( 'admininfo',session('admin'));
        return $this->fetch("common/top");
    }


    public function nav ()

    {       $this->assign('catename',input('catename'));
        return $this->fetch("common/nav");
    }
}