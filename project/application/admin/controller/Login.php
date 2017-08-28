<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/26
 * Time: 10:54
 */

namespace app\admin\controller;


use think\Controller;

class Login extends  Controller
{
    /*管理员登陆页面*/
    public function loginlst()
    {
        return $this->fetch("login");
    }

    public function login()
    {
        if (request()->isPost()) {
            //接受登录信息
            $data = [
                'username' => (input('name')),
                'password' => md5(input('psw')),
                'code'=>input('code')
            ];
            dump($data);
            $vali = validate("Admin");
            //数据验证
            if ( !$vali->scene("login")->check($data)) {
                //验证码验证
                $captcha = $data['code'];
                if (empty($captcha)) {
                    return $this->error('验证码不能为空！');
                }
                $return_result = $this->validate(['captcha' => $captcha],[
                    'captcha|验证码'=>'require|captcha'
                ]);
                if ( $return_result === true ){
                    dump("验证码成功");
                }else{
                    dump("验证码错误");
                    return $this->error($return_result,"login/login");
                }
                $sql =db()->getLastSql();
                dump($sql);
                    $userinfo=db("admin")->where('name', $data['username'])->find();
                    dump($userinfo);
                    //账号存在
                    if ($userinfo&&isset($userinfo)) {
//                      账号md5验证
                        if($userinfo['name']==($data['username'])){
//                            密码MD5验证
                            if ($userinfo['psw']==($data["password"])){
                                session("admin",['name'=>$userinfo['name'],'id'=>$userinfo['id']]);
                                $this->success("登录成功",url("index/index"));
                            }else{
                                $this->error("账号密码错误", "login/login");
                            }
                        }else{
                            $this->error("账号密码错误", "login/login");

                        }
                    }


            } else {dump("数据信息验证失败");
                return $this->error("数据信息验证失败", "login/login");
            }
        }

    }



}