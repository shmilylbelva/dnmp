<?php
/**
 * Created by shmilyelva
 * Date: 2018-10-10
 * Time: 13:40
 */

namespace app\api\controller\v1;


use app\api\validate\DataValidate;
use app\api\service\Pay as servicePay;

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

}