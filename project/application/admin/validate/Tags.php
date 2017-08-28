<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/26
 * Time: 16:28
 */

namespace app\admin\validate;


use think\Validate;

class Tags extends  Validate
{

    protected  $rule= [
        'name'  => 'require|unique:tags',
    ];
    protected $message = [
        'name.max'   => '链接名称最多不能超过25个字符',

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