<?php
/**
 * Created by shmilyelva
 * Date: 2018-10-09
 * Time: 15:07
 */

namespace app\api\model;


class Order extends Base
{
    protected $hidden = ['update_time', 'delete_time', 'user_id'];

    public function getSnapItemsAttr($value) {
        if (empty($value)) {
            return null;
        }
        return json_decode($value);
    }

    public function getSnapAddressAttr($value) {
        if (empty($value)) {
            return null;
        }
        return json_decode($value);
    }

    public static function createOrder($data)
    {
        return self::create($data);
    }

    public static function getSummaryByUser($uid, $page, $size)
    {
        return self::where('user_id', '=', $uid)->order(['create_time' => 'desc'])->paginate($size, true, ['page' => $page]);
    }

    public function getDetail($uid, $id)
    {
        return self::where(['user_id' => $uid,'id' => $id])->get();
    }

}