<?php
/**
 * Created by shmilyelva
 * Date: 2018-10-18
 * Time: 16:55
 */

namespace app\api\service;

use app\api\model\Order as modelOrder;
use app\api\service\Order as orderService;

require_once Env::get('root_path') . 'extend/WxPay/WxPay.Api.php';

class WxNotify extends \WxPayNotify
{
    /**
    <xml>
    <appid><![CDATA[wx2421b1c4370ec43b]]></appid>
    <attach><![CDATA[支付测试]]></attach>
    <bank_type><![CDATA[CFT]]></bank_type>
    <fee_type><![CDATA[CNY]]></fee_type>
    <is_subscribe><![CDATA[Y]]></is_subscribe>
    <mch_id><![CDATA[10000100]]></mch_id>
    <nonce_str><![CDATA[5d2b6c2a8db53831f7eda20af46e531c]]></nonce_str>
    <openid><![CDATA[oUpF8uMEb4qRXf22hE3X68TekukE]]></openid>
    <out_trade_no><![CDATA[1409811653]]></out_trade_no>
    <result_code><![CDATA[SUCCESS]]></result_code>
    <return_code><![CDATA[SUCCESS]]></return_code>
    <sign><![CDATA[B552ED6B279343CB493C5DD0D78AB241]]></sign>
    <sub_mch_id><![CDATA[10000100]]></sub_mch_id>
    <time_end><![CDATA[20140903131540]]></time_end>
    <total_fee>1</total_fee>
    <coupon_fee><![CDATA[10]]></coupon_fee>
    <coupon_count><![CDATA[1]]></coupon_count>
    <coupon_type><![CDATA[CASH]]></coupon_type>
    <coupon_id><![CDATA[10000]]></coupon_id>
    <coupon_fee><![CDATA[100]]></coupon_fee>
    <trade_type><![CDATA[JSAPI]]></trade_type>
    <transaction_id><![CDATA[1004400740201409030005092168]]></transaction_id>
    </xml>
     */
    public function NotifyProcess($objData, $config, &$msg)
    {
        if ($objData['result_code'] == 'SUCCESS') {
            $orderNo = $objData['out_trade_no'];
            try {
                $order = modelOrder::where('order_no','=',$orderNo)->find();
                if ($order->status == 1) {
                    $service = new orderService();
                    $status = $service->checkOrderStock($order->id);
                    if ($status['pass']) {
                        $this->updateOrderStatus();//更新订单状态
                        $this->reduceStack();//减库存
                    }
                }
            } catch (\Exception $e) {

            }
        }
    }
}