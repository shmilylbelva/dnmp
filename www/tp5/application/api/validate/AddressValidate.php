<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-28
 * Time: 13:30
 */

namespace app\api\validate;


class AddressValidate extends BaseValidate
{
    protected $rule = [
        'name' => 'require|notEmpty',
        'mobile' => 'require|isMobile',
        'province' => 'require|notEmpty',
        'city' => 'require|notEmpty',
        'country' => 'require|notEmpty',
        'detail' => 'require|notEmpty',
    ];
    protected $message = [
        'name' => '收货人必须要传'
    ];
}