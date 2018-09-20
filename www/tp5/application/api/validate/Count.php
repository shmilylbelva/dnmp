<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-20
 * Time: 14:52
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule = [
        'count' => 'isPositiveInteger|between:1,15'
    ];

    protected $message = [
        'count' => '数量为1到15'
    ];
}