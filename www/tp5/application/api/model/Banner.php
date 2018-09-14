<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-13
 * Time: 15:09
 */

namespace app\api\model;


use think\Db;
use think\Model;

class BannerItem extends Model
{
    public static function getBannerById($id){
        $result = Db::table('banner_item')->where('id',$id)->find();
        return $result;
    }
}