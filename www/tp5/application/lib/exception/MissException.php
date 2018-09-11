<?php
/**
 * Created by shmilyelva
 * Date: 2018/9/11
 * Time: 上午10:21
 */

namespace app\lib\exception;


class MissException extends BaseException
{
    public $code = 400;
    public $msg = '资源未找到';
    public $errorCode = 10001;
}