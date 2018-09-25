<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-21
 * Time: 12:00
 */

namespace app\api\model;


use think\Model;

class Category extends Model
{
    protected $hidden = [
        'delete_time','update_time','description'
    ];
    public function img(){
        return $this->belongsTo('Image','topic_img_id','id');
    }
    public function product(){
        return $this->hasMany('Product','category_id','id');
    }

    public static function getCategories(){
//        return self::all([],'img');
        return self::with('img')->fetchCollection()->select();
    }
}