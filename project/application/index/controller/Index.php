<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        /*默认为第一个栏目*/
        $article=  db("article")->alias("a")->field(['a.id', 'title','time','pic','desc','keywords'])->join("cate c",'a.cateid=c.id')->where('c.id=1')->limit(0,4)->paginate(4);
        $cateid= input('cateid');
        $tagname = input('tagname');
        $tagsname = input('tagsname');
        /*点击栏目*/
        if ($cateid&&isset($cateid)) {
            $article= db("article")->alias("a")->field(['a.id', 'title','time','pic','desc','keywords'])->join("cate c",'a.cateid=c.id')->where('cateid',$cateid)->paginate(4);
        }
        /*点击标签*/
        if ($tagname&&isset($tagname)){
            $article=db("article")->alias("a")->field(['a.id', 'title','time','pic','desc','keywords'])->where(' keywords like :keywords ')->bind(['keywords'=>'%'.$tagname.'%'])->paginate(4);
        }
        if ($article&&isset($article)) {
            foreach ($article as $a){
                $a['keywords']=str_replace('，', ',', $a['keywords']);
            }

                    /* 搜索 多关键词匹配*/
            if ($tagsname&&isset($tagsname)) {
                /*定义链头*/
                $article= db('article')->alias('a');
                /*形成OR链*/
                foreach (explode(' ', $tagsname) as $k) {
                    /*条件子链*/
                    $where['keywords']=['like','%'.$k.'%'];
                    /*添加子链*/
                    $article =$article ->whereOr($where);
                }
                /*执行查询链*/
                $article= $article->field(['a.id', 'title','time','pic','desc','keywords'])->select();
            }
            $this->assign('article', $article);
            return $this->fetch("index");
        } else {
            return $this->error("article变量不存在");
        }




    }
}
