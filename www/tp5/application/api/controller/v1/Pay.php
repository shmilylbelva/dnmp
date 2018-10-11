<?php
/**
 * Created by shmilyelva
 * Date: 2018-10-10
 * Time: 13:40
 */

namespace app\api\controller\v1;


use app\api\validate\DataValidate;
use app\api\service\Order as orderService;

class Pay
{
    //中间件
    protected $middleware = [
        'ExclusiveScope' => ['only' => ['getPreOrder']]
    ];

    public function getPreOrder($orderID)
    {
        (new DataValidate())->goCheck();
        $order = new orderService();
        return $order->checkOrderStock($orderID);
    }

}