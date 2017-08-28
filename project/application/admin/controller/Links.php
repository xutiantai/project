<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/26
 * Time: 11:04
 */

namespace app\admin\controller;


class links extends Base
{/*
         * 管理员列表
         * */
    public function lst()
    {
        $linkslist = db('links')->paginate(5);
        $this->assign('links', $linkslist);
        return $this->fetch("list");
    }

    /**
     *添加管理员页面
     */
    public function addlst()
    {
        return $this->fetch("add");
    }

    /**
     *添加管理员
     */
    public function add()
    {
//        获得数据
        if (request()->isPost()) {
            /*必有*/
            $links = ['id' => input('id'),
                /*改*/
                'name' => (input('name')),
                'url' => (input('url')),
            ];
        }
        dump('input获取数据');
        dump($links);
        /*验证数据*/
        /*  $vali=validate('links');
          $valiret=$vali->scene("add")->check($links);
          dump($valiret);
          if (!$valiret) {
              dump();
              $this->error($vali->getError());

          }*/

        $validate = validate("links");
        if (!($validate->check($links))) {
            return $this->error($validate->getError());
        };
        dump('开始查找数据库');
        $res = db("links")->insert($links);
        dump($res);
        if ($res) {
            $this->success("添加成功", 'links/lst');
        } else {
            $this->error("添加失败", 'links/lst');
        }
    }

    /**
     *删除管理员
     */
    public function delete()
    {
        $id = input('id');
        if ($id && isset($id)) {
            $res = db('links')->where(['id' => $id])->delete();
            if ($res) {
                $this->success("删除成功", 'links/lst');
            }
        }

    }

    /**
     *更改管理员页面
     */
    public function updatelst()
    {
//        获取ID
        $id = input('id');
//       绑定ID
        $this->assign('links', db('links')->find($id));
        return $this->fetch("update");
    }

    /**
     *更改管理员
     */
    public function update()
    {
        if (request()->isPost()) {
            $links = [
                /*lst 传过来的 改 */
                'id' => input('id'),
                'name' => input('name'),
                'url' => input('url'),
            ];
            if ($res = !validate('links')->scene("update")->check($links)) {
                return $res;
            };
            $res = db('links')->update($links);

            return $res ? $this->success("修改成功", 'links/lst') : $this->error("修改成功", 'links/lst');
        }


    }
}