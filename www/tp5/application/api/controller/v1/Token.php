<?php
/**
 * Created by shmilyelva
 * Date: 2018/9/26
 * Time: 下午8:16
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;

class Token
{
    public function getToken($code = '')
    {
        (new TokenGet())->goCheck();
        $ut = new UserToken();        print_r($code);exit();
        $result = $ut->get($code);
        return $result;
    }
}