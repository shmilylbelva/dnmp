<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-28
 * Time: 15:20
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = '当前用户不存在';
    public $errorCode = 50000;
}