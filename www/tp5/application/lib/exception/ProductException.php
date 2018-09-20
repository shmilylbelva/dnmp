<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-20
 * Time: 15:01
 */

namespace app\lib\exception;


class ProductException extends BaseException
{
    public $code = 404;
    public $msg = '指定的商品不存在';
    public $errorCode = 20000;
}