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
//        $code = request()->param('code');
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        return [
            'token' => $token
        ];
    }
}