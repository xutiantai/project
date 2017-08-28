<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/26
 * Time: 12:34
 */

namespace app\admin\validate;
use think\Validate;
class Admin extends  Validate
{
    protected  $rule= [

        'name'  => 'require|unique:admin',
        'psw'  => 'require',
    ];
protected $message = [
'name.require' => '管理員名称必须',
'name.unique' => '管理員名称不可以重复',
'name.max'     => '管理員名称最多不能超过25个字符',
'psw.require' =>'必须有密码',
'psw.min'=>'密码最少6位'
];
/*
 * 管理員名称无法修改
 * 密码可修改
*/
    protected $scene = [
        'add'   =>  ['name','psw'],
        'update'  =>  ['psw'],
        'login'=>['name']

    ];
}