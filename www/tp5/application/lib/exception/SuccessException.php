<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-28
 * Time: 16:48
 */

namespace app\lib\exception;


class SuccessException
{
    public $code = 201;
    public $msg = 'success';
    public $errorCode = 0;
}