<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/26
 * Time: 11:04
 */

namespace app\admin\controller;

use think\Validate;

class Cate extends Base
{
    /*
         * 栏目列表
         * */
    public function lst()
    {
        $catelist = db('cate')->paginate(5);
        $this->assign('cate', $catelist);
        return $this->fetch("list");
    }

    /**
     *添加栏目页面
     */
    public function addlst()
    {
        return $this->fetch("add");
    }

    /**
     *添加栏目
     */
    public function add()
    {
//        获得数据
        if (request()->isPost()) {

            $cate = [
                /*改*/
                'name' => (input('name')),
            ];
        }
        dump('input获取数据');
        $validate = validate("Cate");
        if (!($validate->scene("add")->check($cate))) {
            return $this->error($validate->getError());
        };

        $res = db("cate")->insert($cate);

        if ($res) {
            $this->success("添加成功", 'cate/lst');
        } else {
            $this->error(   "添加失败", 'cate/lst');
        }
    }

    /**
     *删除栏目
     */
    public function delete()
    {
        $id = input('id');
        if ($id && isset($id)) {
            $res = db('cate')->where(['id' => $id])->delete();
            if ($res) {
                $this->success("删除成功", 'cate/lst');
            }
        }

    }

    /**
     *更改栏目页面
     */
    public function updatelst()
    {
//        获取ID
        $id = input('id');
//       绑定ID
        $this->assign('cate', db('cate')->find($id));
        return $this->fetch("update");
    }

    /**
     *更改栏目
     */
    public function update()
    {
        if (request()->isPost()) {
            $cate = [
                /*lst 传过来的 改 */
                'id' => input('id'),
                'name' => input('name'),
            ];
            if ($res = !validate('Cate')->scene("update")->check($cate)) {
                return $res;
            };
            $res = db('cate')->update($cate);

            return $res ? $this->success("修改成功", 'cate/lst') : $this->error("修改成功", 'cate/lst');
        }


    }
}