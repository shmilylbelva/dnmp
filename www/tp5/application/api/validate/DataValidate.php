<?php
/**
 * Created by shmilyelva
 * Date: 2018/9/6
 * Time: 下午10:09
 */

namespace app\api\validate;

use think\Validate;

class DataValidate extends Validate
{
    protected $rule = [
        'name' => 'require|max:10',
        'email' => 'email',
        'id' => 'number',
        'class' => 'number'
    ];

    protected $message = [
        'name.require' => '姓名必填',
        'name.max' => '姓名不能超过10个字符',
        'email' => '邮件格式错误',
        'id' => 'id应为数字',
        'class' => 'class应为数字'
    ];


    protected  $scene = [
        'login' => ['name'],
        'repass' => ['name','email'],
        'false' => ['name','email','class']
    ];
}