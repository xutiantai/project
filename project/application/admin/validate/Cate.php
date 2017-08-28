<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/26
 * Time: 16:28
 */

namespace app\admin\validate;


use think\Validate;

class Cate extends  Validate
{
    protected  $rule = [
        'name'  => 'require|unique:cate',
    ];
    protected $message = [
        'name.max'   => '栏目名称最多不能超过25个字符',
        'name.require'=>'必须输入栏目',
        'name.unique'=>'栏目不能重复',

    ];
    /*
     * 管理員名称无法修改
     * 密码可修改
     *
    */
    protected $scene = [
        'add'   =>  ['name'],
        'update'  =>  ['name'],

    ];
}