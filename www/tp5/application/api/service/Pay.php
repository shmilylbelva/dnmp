<?php
/**
 * Created by shmilyelva
 * Date: 2018-10-10
 * Time: 14:05
 */

namespace app\api\service;


use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use app\api\model\Order as modelOrder;
use app\api\service\Order as orderService;
use think\facade\Env;
use think\facade\Log;

//use WxPay;

require_once Env::get('root_path') . 'extend/WxPay/WxPay.Api.php';

class Pay
{
    private $orderID;
    private $orderNO;

    function __construct($orderID)
    {
        if (!$orderID) {
            throw new Exception('订单号不能为空');
        }
        $this->orderID = $orderID;
    }

    public function pay()
    {
        //订单号是否存在
        //订单号和用户信息是否匹配
        //订单是否已成功支付
        //进行库存量检测
        $this->checkOrderValid();
        $orderService = new orderService();
        $status = $orderService->checkOrderStock($this->orderID);
        if (!$status['pass']) {
            return $status;
        }
        return $this->makeWxPreOrder($status['orderPrice']);
    }

    //微信支付
    private function makeWxPreOrder($totalPrice)
    {
        $openid = Token::getCurrentTokenVar('openid');
        if (!$openid) {
            throw new TokenException();
        }
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNO);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice * 100);
        $wxOrderData->SetBody(config('setting.shop_name'));
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url(config('wx.notify_url'));
        return $this->getPaySignature($wxOrderData);
    }

    //
    private function getPaySignature($wxOrderData)
    {
        $config = new \WxPayConfig();
        $wxOrder = \WxPayApi::unifiedOrder($config, $wxOrderData);
        if ($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['return_code'] != 'SUCCESS') {
            Log::record($wxOrder, 'error');
            Log::record('获取预支付订单失败', 'error');
        }
        $this->recordPreOrder($wxOrder);
        $signature = $this->sign($wxOrder,$config);
        return $signature;
    }

    private function sign($wxOrder,$config)
    {
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());
        $rand = md5(time().mt_rand(0,1000));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage('prepay_id='.$wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');
        $sign = $jsApiPayData->MakeSign($config);
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;
        unset($rawValues['appId']);
        return $rawValues;
    }

    private function recordPreOrder($wxOrder)
    {
        modelOrder::where('id', '=', $this->orderID)->update(['prepay_id' => $wxOrder['prepay_id']]);
    }

    //  检测订单是否存在
    private function checkOrderValid()
    {
        $order = modelOrder::where('id', '=', $this->orderID)->find();

        if (!$order) {
            throw new OrderException();
        }
        if (!Token::isValidOperate($order->user_id)) {
            throw new TokenException([
                'msg' => '订单与用户不匹配',
                'errorCode' => 10003
            ]);
        };

        if ($order->status != OrderStatusEnum::UNPAID) {
            throw new OrderException([
                'msg' => '订单已支付',
                'errorCode' => 80003,
                'code' => 400
            ]);
        }
        $this->orderNO = $order->order_no;
        return true;
    }
}