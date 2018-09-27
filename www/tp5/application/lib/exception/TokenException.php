<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-27
 * Time: 14:52
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'Token已过期或无效';
    public $errorCode = 10001;
}