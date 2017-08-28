<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/26
 * Time: 11:00
 */

namespace app\admin\controller;

use app\admin\controller\Base;
use think\Controller;

class Article extends Base

{
    public function lst()
    {
        $articlelist = db('article')->alias('a')->field(['a.id','a.desc','title','keywords','author','pic  ','state','cateid','name','time','click'])->join('cate c','a.cateid = c.id')->paginate();
        $this->assign('article', $articlelist);
        foreach ($articlelist as $a) {
            $keywords = str_replace("，", ",", $a['keywords']);
            $keywords = explode(",", $keywords);
            dump($keywords);
        }
        return $this->fetch("list");
    }

    /**
     *添加管理员页面
     */
    public function addlst()
    {
        $path = null;
        if (request()->isPost()) {
            $ret = preg_match("/^[a-zA-Z0-9+\/=.@_]+(jpeg|png|jpg|gif|bmp)$/", $_FILES['pic']['name']);
            if ($_FILES['pic']['tmp_name']) {
                if (!$ret) {
                    $this->error("图片格式错误");
                }
                $file = request()->file('pic');
//                文件转移到uploads文件夹
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if ($info) {
                    $path = str_replace('\\', '/', $info->getSaveName());
                    $this->assign('imgpath', $path);
                }
            }
            $article = [
                'id' => input('id'),
                /*改*/
                'desc' => (input('desc')),
                'title' => (input('title')),
                'keywords' => (input('keywords')),
                'content' => (input('content')),
                'author' => (input('author')),
                'pic' => (input('pic')),
                'state' => (input('state')),
                'cateid' => (input('cateid')),
            ];
          
//            更新图片后刷新页面，重新填入原有数据
            $this->assign('article', $article);
        } else {
            $this->assign('article', null);
        }
        $cate = db('cate')->field(['id', 'name'])->select();
        $this->assign('cates', $cate);
        $this->assign('imgpath', $path);
        return $this->fetch("add");
    }
    /*删除缓存图片*/
    public function deletetmpimg()
    {

    }

    /**
     *添加
     */
    public function add()
    {
        if (request()->isPost()) {
//        获得数据
            /*必有*/

            $article = [
                'id' => input('id'),
                /*改*/
                'desc' => (input('desc')),
                'title' => (input('title')),
                'keywords' => (input('keywords')),
                'content' => (input('content')),
                'author' => (input('author')),
                'pic' => (input('picpath')),
                'state' => (input('state')),
                'cateid' => (input('cateid')),
            ];
                    $article['time'] = time();
            dump($article);
        }
        /*验证数据*/
        $validate = validate("article");
        if (!($validate->scene("add ")->check($article))) {
            return $this->error($validate->getError());
        };
        $res = db("article")->insert($article);
        dump($res);
        if ($res) {
            $this->success("添加成功", 'article/lst');
        } else {
            $this->error("添加失败", 'article/lst');
        }
    }
    /**
     *删除
     */
    public function delete()
    {
        $id = input('id');
        if ($id && isset($id)) {
            $res = db('article')->where(['id' => $id])->delete();
            if ($res) {
                $this->success("删除成功", 'article/lst');
            }
        }
    }
    /**
     *更改管理员页面
     */
    public function updatelst()
    {
        $cate = db('cate')->field(['id', 'name'])->select();
        $this->assign('cates', $cate);
//        获取ID
        $id = input('id');

//        声明缩略图路径
        $path = null;
//       有缩略图上传
        /*
         * 1检查图片格式
         * 2保存图片到服务器
         * 3 保存原有数据
         * 4刷新页面填入原有数据(图片显示服务器返回的数据)
         * 5显示图片
         * 6点击提交后，服务器上传至数据库，并删除缓存图
         * */
        if (request()->isPost()) {
            $ret = preg_match("/^[a-zA-Z0-9+\/=.@_]+(jpeg|png|jpg|gif|bmp)$/", $_FILES['pic']['name']);
            if ($_FILES['pic']['tmp_name']) {
                if (!$ret) {
                    $this->error("图片格式错误");
                }
//                获取图片文件
                $file = request()->file('pic');
//                文件转移到uploads文件夹
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if ($info) {
//                    替换可识别的路径分隔符
                    $path = str_replace('\\', '/', $info->getSaveName());
//                    图片路径为临时缓存（非数据库原有）
                    $this->assign('imgpath', $path);
                }
            }
        /*保存原有数据*/
            $article = [
                'id' => input('id'),
                /*改*/
                'desc' => (input('desc')),
                'title' => (input('title')),
                'keywords' => (input('keywords')),
                'content' => (input('content')),
                'author' => (input('author')),
                'pic' => (input('pic')),
                'state' => (input('state')),
                'cateid' => (input('cateid')),
            ];
            dump($article);
//            更新图片后刷新页面，重新填入原有数据
            $this->assign('article', $article);
        } else {
//            如果没有上传图片，填入数据库的数据
            //     根据id查询数据库并绑定article到模板
            $article = db('article')->find($id);
            $this->assign('article', $article);
            //        图片路径为数据库原有
            $this->assign('imgpath', $article['pic']);
        }

        return $this->fetch("update");
    }
    /**
     *更改
     */
    public function update()
    {
        if (request()->isPost()) {
            $article = [
                'id' => input('id'),
                /*改*/
                'desc' => (input('desc')),
                'title' => (input('title')),
                'keywords' => (input('keywords')),
                'content' => (input('content')),
                'author' => (input('author')),
                'time' => (time()),
                'pic' => input('picpath'),
                'state' => (input('state')=='on'?1:0),
                'cateid' => (input('cateid')),
            ];
            dump($article);
            /*处理pic*/
//            'pic' => (input('pic')),
            if (!validate('Article')->scene("update")->check($article)) {
                return $this->error("数据格式错误");

            };
            $res = db('article')->update($article);
            dump(db()->getLastSql());
            return $res==true? $this->success("修改成功", 'article/lst') : $this->error("修改成功", 'article/lst');
        }
    }
}