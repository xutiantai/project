<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/27
 * Time: 22:01
 */

namespace app\index\widget;


use think\Controller;

class Widget extends  Controller
{
    public function top()
    {
        $cate=db('cate')->field(['id','name'])->select();
        $this->assign('cate', $cate);
        return $this->fetch("common/top");
    }
//    热门点击
    public function hotmenu()
    {
        $hotmenu=db('tags')->field(['name', 'id'])->order('id desc')->limit(0,7)->select();
        $this->assign('hotmenu',$hotmenu);

        return $this->fetch("common/hotmenu");
    }
    public function right()
    {
        $pushread = db("article")->alias("a")->field(['a.id','title'])->join("cate c",'a.cateid=c.id')->where('state=1')->limit(0,4)->select();
        $hotclick = db('article')->alias("a")->field(['a.id','title'])->join("cate c",'a.cateid=c.id')->order('click desc')->limit(0, 4)->select();

        $this->assign('pushread', $pushread);

        $this->assign('hotclick', $hotclick);
        return $this->fetch("common/right");
    }
}