<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/27
 * Time: 21:53
 */

namespace app\index\controller;


class Article extends Base
{
    public function article()
    {
        $id=input('id');
        if ($id&&isset($id)) {
            $article = db('article');
            $article ->where('id',$id)->setInc('click',1);//自增
            //根据ID查找当前文章
            $article= $article->find($id);
            if ($article&&isset($article)) {
            $catename= db('cate')->find($article['cateid'])['name'];
            $cateid= db('cate')->find($article['cateid'])['id'];
            $this->assign('catename', $catename);
            $this->assign('cateid',$cateid);
            }
            $this->assign('article', $article);
        }else{
            $this->error("文章不存在或者被刪除", 'index/index');
        }
        /*相关阅读*/
        /*分割字符串*/
       /*定义链头*/
        $relarticle= db('article');
        /*形成OR链*/
        foreach (explode('，', $article['keywords']) as $k) {
            /*条件子链*/
            $where['keywords']=['like','%'.$k.'%'];
            /*添加子链*/
            $relarticle =$relarticle ->whereOr($where);
        }
        /*执行查询链*/
        $relarticle= $relarticle->select();
        db()->getLastSql();
        /*SELECT * FROM `project_article` WHERE
         ( `keywords` LIKE '%朝鲜%'
        OR `keywords` LIKE '%金三胖%'
        OR `keywords` LIKE '%美国%' )*/
        $this->assign('relarticle', $relarticle);
        /*频道推荐*/
        /*定义链头*/
        $hotsnew=db('article')->alias('a')->join('cate c','a.cateid=c.id')->field(['a.id,a.title,pic'])->select();
        $this->assign('hotsnew', $hotsnew);
        return $this->fetch();

    }
}