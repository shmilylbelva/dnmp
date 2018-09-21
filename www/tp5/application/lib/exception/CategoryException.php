<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-21
 * Time: 14:10
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code = 400;
    public $msg = '请求的类目不存在，请检查参数';
    public $errorCode = 10001;
}