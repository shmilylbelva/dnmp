<?php

namespace app\api\model;

class Theme extends Base
{
    //
    protected $hidden = ['delete_time', 'update_time'];

    public function topicImg()
    {
        return $this->belongsTo('image', 'topic_img_id', 'id');
    }

    public function headImg()
    {
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany('Product','theme_product','product_id','theme_id');
    }

    public static function getThemeByIds($ids)
    {
        return self::with('topicImg,headImg')->select($ids);
    }
    public static function getThemeListById($id)
    {
        return self::with('products,topicImg,headImg')->get($id);
    }
}
