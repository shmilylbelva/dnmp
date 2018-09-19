<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-13
 * Time: 15:09
 */

namespace app\api\model;

use think\Model;

class Banner extends Model
{
    protected $hidden = ['delete_time', 'update_time', 'id'];

    public function items()
    {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    public static function getBannerById($id)
    {
//         hidden(['create_time','update_time']);
        return self::with(['items', 'items.img'])->append(['id'])->find($id);//toJson
    }
}