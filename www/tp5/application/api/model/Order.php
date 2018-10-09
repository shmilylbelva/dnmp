<?php
/**
 * Created by shmilyelva
 * Date: 2018-10-09
 * Time: 15:07
 */

namespace app\api\model;


class Order extends Base
{
    protected $hidden = ['update_time','delete_time','user_id'];

    public static function createOrder($data){
        return self::create($data);
    }
}