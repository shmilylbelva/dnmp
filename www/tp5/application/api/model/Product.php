<?php

namespace app\api\model;

class Product extends Base
{
    //
    protected $hidden = [
        'delete_time', 'main_img_id', 'update_time', 'create_time', 'from', 'prvot', 'category_id'
    ];

    public function contentImg(){
//        return $this->hasMany('ProductImage','product_id','id');
        return $this->hasMany('ProductImage','product_id','id')->order('order','asc');
    }

    public function property(){
        return $this->hasMany('ProductProperty','product_id','id');
    }
    public function getMainImgUrlAttr($value, $data)
    {
        $prefix = config('setting.img_prefix_goods');
        return $this->prefixImgUrl($value, $data, $prefix);
    }

    public static function getRecent($count)
    {
        return self::limit($count)->order('id', 'desc')->select();
    }

    public static function getAllInCategory($id)
    {
        return self::where('category_id', '=', $id)->select();
    }

//'contentImg' => function($query){
//    $query->order('order','asc');
//}
    public static function detail($id)
    {
        return self::with(['contentImg.img','property'])->get($id);
    }
}
