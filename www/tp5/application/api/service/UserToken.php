<?php
/**
 * Created by shmilyelva
 * Date: 2018/9/26
 * Time: 下午8:28
 */

namespace app\api\service;

use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as modelUser;

class UserToken extends Token
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
            $loginFail = array_key_exists('errcode', $wxResult);
            if ($loginFail) {
                $this->processLoginError($wxResult);
            } else {
                return $this->grantToken($wxResult);
            }
        }
    }

    private function processLoginError($wxResult)
    {
        throw new WeChatException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode']
        ]);
    }

    private function grantToken($wxResult)
    {
        $result = modelUser::getUserByOpenId($wxResult['openid']);
        //如果openid存在
        if ($result) {
            $uid = $result->id;
        }else{
            $user = modelUser::addUser($wxResult['openid']);
            $uid = $user->id;
        }
        $cacheValue = $this->prepareCacheValue($wxResult,$uid);
         return $this->saveCache($cacheValue);
    }

    private function prepareCacheValue($wxResult,$uid){
        $cacheValue = $wxResult;
        $cacheValue['uid'] = $uid;
        $cacheValue['scope'] = 16;
        return $cacheValue;
    }

    private function saveCache($cacheValue){
        $key = self::generateToken();
        $value = json_encode($cacheValue);
        $expire_in = config('setting.token_expire_in');
        $request = cache($key,$value,$expire_in);
        if (!$request){
            throw new TokenException([
                'msg' => '服务器异常',
                'errorCode' => '10005'
            ]);
        }
        return $key;
    }
}