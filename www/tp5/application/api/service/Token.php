<?php
/**
 * Created by shmilyelva
 * Date: 2018/9/26
 * Time: 下午8:28
 */

namespace app\api\service;

use app\lib\exception\TokenException;
use think\facade\Cache;
use think\Exception;

class Token
{
    public static function generateToken($length = 32)
    {
        $randChar = getRandChar($length);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('secure.token_salt');
        return md5($randChar . $timestamp . $salt);
    }

    public static function getCurrentTokenVar($key)
    {
        $token = request()->header('token');
        $vars = Cache::get($token);
        if (!$vars) {
            throw new TokenException();
        } else {
            if (!is_array($vars)) {
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            }else {
                throw new Exception('尝试获取的Token不存在');
            }
        }
    }

    //检测是否为当前用户
    public static function isValidOperate($checkedUID) {
        if (!$checkedUID) {
            throw new Exception('UID不能为空');
        }
        $currentUID = self::getCurrentTokenVar('uid');
        if ($currentUID == $checkedUID) {
            return true;
        }
        return false;
    }

}