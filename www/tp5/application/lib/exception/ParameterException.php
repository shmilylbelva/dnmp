<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-13
 * Time: 10:51
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 10000;
}