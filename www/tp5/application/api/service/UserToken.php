<?php
/**
 * Created by shmilyelva
 * Date: 2018/9/26
 * Time: 下午8:28
 */

namespace app\api\service;


use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as modelUser;

class UserToken
{
    protected $app_secret;
    protected $app_id;
    protected $code;
    protected $wxLoginUrl;

    function __construct($code)
    {
        $this->code = $code;
        $this->app_id = config('wx.app_id');
        $this->app_secret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_ur'), $this->app_id, $this->app_secret, $this->code);

    }

    public function get()
    {
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result, true);
        if (empty($wxResult)) {
            throw new Exception('获取session_key以及open_id时异常，微信内部错误');//抛出tp自带错误，记录到日志
        } else {
            $loginFail = array_key_exists('errorCode', $wxResult);
            if ($loginFail) {
                $this->processLoginError($wxResult);
            } else {
                $this->grantToken($wxResult);
            }
        }
    }

    private function processLoginError($wxResult)
    {
        throw new WeChatException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errCode']
        ]);
    }

    private function grantToken($wxResult)
    {
        $result = modelUser::getUserByOpenId($wxResult['openid']);
        //如果openid不存在
        if (!$result) {
            modelUser::create(['openid' => $wxResult['openid']]);
        }
        return true;
    }
}