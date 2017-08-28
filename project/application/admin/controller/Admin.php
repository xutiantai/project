<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/26
 * Time: 10:39
 */

namespace app\admin\controller;


use app\admin\controller\Base;
use think\Controller;
use think\Db;

class Admin extends Base
{
    /**
     *管理员退出登录
     */
    public function logout()
    {
        session('admin', null);
        if (session('admin') == null) {
            $this->success("退出成功", 'index/index');
        }
    }
    /*
     * 管理员列表
     * */
    public function lst()
    {
        $adminlist = db('admin')->paginate(4);
        $this->assign('admin', $adminlist);
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
            $admin = [
                'name'=> input('name'),
                'psw'=> md5(input('psw')),
            ];
        }
        dump('input获取数据');
        dump($admin);
        /*验证数据*/
      /*  $vali=validate('Admin');
        $valiret=$vali->scene("add")->check($admin);
        dump($valiret);
        if (!$valiret) {
            dump();
            $this->error($vali->getError());
        }*/
        $validate = validate("Admin");
        if (!$validate->scene("add")->check($admin)) {
            return $this->error($validate->getError());
        };
        dump('开始查找数据库');
        $res=db("admin")->insert($admin);
        dump($res);
        if ($res){
            $this->success("添加成功", 'admin/lst');
        } else {
            $this->error(mysqli_error());
        }
    }
    /**
     *删除管理员
     */
    public function delete()
    {
        $id = input('id');


        if ($id&&isset($id)) {
            if ($id==1) { return $this->error("不具备删除超级管理员的权限", 'admin/lst');
            }
            $res=   db('admin')->where(['id' => $id])->delete();
            if ($res) {
                $this->success("删除成功", 'admin/lst');
            }
        }
    }
    /*冻结*/
    public function ban()
    {
        $id = input('id');
        if ($id&&isset($id)) {
            if ($id==1) {
                return $this->error("不具备冻结超级管理员的权限", 'admin/lst');
            }
            $db=db('admin')->where(['id' =>$id]);
            ($db->find()['state'])? $res=$db->update(['id'=>$id,'state'=>0]):$res=$db->update(['id'=>$id,'state'=>1]);
            if ($res) {
                $this->success('操作成功','admin/lst');
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
        dump($id);
//       绑定ID
        dump(db('admin')->find($id));
        $this->assign('admin',db('admin')->find());
        return $this->fetch("update");
    }

    /**
     *更改管理员
     */
    public function update()
    {
        if (request()->isPost()) {
            $admin = [
                'id'=>input('id'),
                'name'=> input('name'),
                'psw'=> md5(input('psw')),
            ];
            $res=db('admin')->update($admin);
            return $res? $this->success("修改成功",'admin/lst'):$this->error("修改成功",'admin/lst');
        }

    }
}