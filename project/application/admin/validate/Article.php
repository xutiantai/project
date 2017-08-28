<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/26
 * Time: 16:28
 */

namespace app\admin\validate;


use think\Validate;

class Article extends  Validate
{
    protected  $rule= [
        'title' =>'require|unique:article',
        'keywords' =>'require',
        'content' => 'require',
        'author' => 'require',

        'cateid' => 'require',
    ];


    protected $message = [
        'name.max'   => '栏目名称最多不能超过25个字符',

    ];
    /*
     * 管理員名称无法修改
     * 密码可修改
     *
    */
    protected $scene = [
        'add'   =>  ['title','cateid'],
        'update'  =>  ['name'],

    ];
}