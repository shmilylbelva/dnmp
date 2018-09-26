<?php
/**
 * Created by shmilyelva
 * Date: 2018/9/26
 * Time: 下午8:18
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule = [
      'code' => 'require|notEmpty'
    ];
    protected $message = [
        'code' => 'code必须要传'
    ];


}