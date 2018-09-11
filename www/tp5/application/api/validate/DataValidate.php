<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-06
 * Time: 17:07
 */

namespace app\api\validate;

class DataValidate extends BaseValidate
{
    protected $rule = [
        'name' => 'require|max:25',
        'age' => 'require|number|between:1,120',
        'email' => 'require|email',
    ];

    protected $message = [
        'name.require' => '名称必须填写',
        'name.max' => '名称最多不能超过25个字符',
        'age.number' => '年龄必须是数字',
        'age.between' => '年龄只能在1-120之间',
        'email' => '邮箱格式错误',
    ];

    protected $scene = [
        'test' => ['name'],
        'test1' => ['name','age']
    ];

    protected function isPostiveInt($value, $rule, $data = '', $field)
    {
        if (is_numeric($value)) {
            return true;
        } else {
            return $field . '必须是整数';
        }
    }
}