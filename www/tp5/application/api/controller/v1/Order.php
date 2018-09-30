<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-30
 * Time: 11:33
 */

namespace app\api\controller\v1;

use app\api\validate\PlaceOrder;
use think\Controller;

class Order extends Controller
{
//    protected  $middleware = [
//        'ExclusiveScope' => ['only' => ['placeOrder']]
//    ];

    public function placeOrder(){
        (new PlaceOrder())->goCheck();
    }
}