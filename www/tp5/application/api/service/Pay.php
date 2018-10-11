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
    }

    //微信支付
    private function makeWxPreOrder() {
        $openid = Token::getCurrentTokenVar('openid');
        if (!$openid) {
            throw new TokenException();
        }
    }

    //  检测订单是否存在
    private function checkOrderValid() {
        $order = modelOrder::where('order_id','=',$this->orderID)->find();
        if (!$order) {
            throw new OrderException();
        }
        if(! Token::isValidOperate($order->user_id)) {
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