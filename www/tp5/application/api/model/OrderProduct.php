<?php
/**
 * Created by shmilyelva
 * Date: 2018-10-09
 * Time: 15:49
 */

namespace app\api\model;


class OrderProduct extends Base
{
    public static function getOrderProduct($orderID){
        return self::where('order_id','=',$orderID)->select()->visible(['count','product_id'])->toArray();
    }
}