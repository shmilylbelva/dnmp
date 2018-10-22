<?php
/**
 * Created by shmilyelva
 * Date: 2018-10-10
 * Time: 13:40
 */

namespace app\api\controller\v1;


use app\api\service\WxNotify;
use app\api\validate\DataValidate;
use app\api\service\Pay as servicePay;
use think\facade\Env;

require_once Env::get('root_path') . 'extend/WxPay/WxPay.Api.php';

class Pay
{
    //中间件
    protected $middleware = [
        'ExclusiveScope' => ['only' => ['getPreOrder']]
    ];

    public function getPreOrder($id)
    {
        (new DataValidate())->goCheck();
        $pay = new servicePay($id);
        return $pay->pay();
    }

    public function redirectNotify(){
        //通知频率 15/15/30/180/1800/1800/1800/3600

        //1.检查库存，防止超卖
        //2.更新订单状态
        //3.减库存
        $config = new \WxPayConfig();
        $notify = new WxNotify();
        $notify->Handle($config);
    }

    public function receiveNotify()
    {
        //通知频率 15/15/30/180/1800/1800/1800/3600

        //1.检查库存，防止超卖
        //2.更新订单状态
        //3.减库存
        $xmlData = file_get_contents('php://input');
        $result = curl_post_raw(config('setting.redirect_notify').'?XDEBUG_SESSION_START=1221',$xmlData);
        return $result;
    }
}