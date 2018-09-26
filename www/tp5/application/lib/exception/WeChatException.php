<?php
/**
 * Created by shmilyelva
 * Date: 2018/9/26
 * Time: 下午8:33
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 404;
    public $msg = '获取用户信息失败';
    public $errorCode = 50000;
}