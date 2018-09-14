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
        'id' => 'require|isPositiveInteger',
        'name' => 'require|max:25',
        'age' => 'require|number|between:1,120',
        'email' => 'require|email',
    ];

    protected $message = [
        'id.email' => 'id必须为邮箱格式',
        'name.require' => '名称必须填写',
        'name.max' => '名称最多不能超过25个字符',
        'age.number' => '年龄必须是数字',
        'age.between' => '年龄只能在1-120之间',
        'email' => '邮箱格式错误',
    ];

    protected $scene = [
        'test' => ['id'],
        'test1' => ['name','age']
    ];

    protected function isPositiveInteger($value, $rule='', $data='', $field='')
    {

        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        return $field . '必须是正整数';
    }

}