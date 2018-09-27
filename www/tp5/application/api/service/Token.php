<?php
/**
 * Created by shmilyelva
 * Date: 2018/9/26
 * Time: 下午8:28
 */

namespace app\api\service;

class Token
{
    public static function generateToken($length = 32){
        $randChar = getRandChar($length);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('secure.token_salt');
        return md5($randChar.$timestamp.$salt);
    }


}