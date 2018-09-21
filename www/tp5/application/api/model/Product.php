<?php

namespace app\api\model;

class Product extends Base
{
    //
    protected $hidden = [
        'delete_time','main_img_id','update_time','create_time','from','prvot','category_id'
    ];
    public function getMainImgUrlAttr($value,$data)
    {
        $prefix = config('setting.img_prefix_goods');
        return $this->prefixImgUrl($value,$data,$prefix);
    }

    public static function getRecent($count){
        return self::limit($count)->order('id', 'desc')->select();
    }
    public static function getAllInCategory($id){
        return self::where('category_id','=',$id)->select();
    }
}
