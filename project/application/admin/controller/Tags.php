<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/26
 * Time: 11:00
 */

namespace app\admin\controller;


class Tags extends Base
{ public function lst()
{
    $tagslist = db('tags')->paginate(5);
    $this->assign('tags', $tagslist);
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
            $tags = ['id' => input('id'),
                /*改*/
                'name' => (input('name')),

            ];
        }
        dump('input获取数据');
        dump($tags);
        /*验证数据*/
        /*  $vali=validate('tags');
          $valiret=$vali->scene("add")->check($tags);
          dump($valiret);
          if (!$valiret) {
              dump();
              $this->error($vali->getError());

          }*/

        $validate = validate("tags");
        if (!($validate->check($tags))) {
            return $this->error($validate->getError());
        };
        dump('开始查找数据库');
        $res = db("tags")->insert($tags);
        dump($res);
        if ($res) {
            $this->success("添加成功", 'tags/lst');
        } else {
            $this->error("添加失败", 'tags/lst');
        }
    }

    /**
     *删除管理员
     */
    public function delete()
    {
        $id = input('id');
        if ($id && isset($id)) {
            $res = db('tags')->where(['id' => $id])->delete();
            if ($res) {
                $this->success("删除成功", 'tags/lst');
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
        $this->assign('tags', db('tags')->find($id));
        return $this->fetch("update");
    }

    /**
     *更改管理员
     */
    public function update()
    {
        if (request()->isPost()) {
            $tags = [
                /*lst 传过来的 改 */
                'id' => input('id'),
                'name' => input('name'),

            ];
            if ($res = !validate('tags')->scene("update")->check($tags)) {
                return $res;
            };
            $res = db('tags')->update($tags);

            return $res ? $this->success("修改成功", 'tags/lst') : $this->error("修改成功", 'tags/lst');
        }


    }
}