<?php
/**
 * Created by shmilyelva
 * Date: 2018-10-08
 * Time: 17:11
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;
    public $msg = '订单不存在';
    public $errorCode = 80000;
}