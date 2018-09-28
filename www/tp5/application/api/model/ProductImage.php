<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-28
 * Time: 9:54
 */

namespace app\api\model;


class ProductImage extends Base
{
    protected $hidden = ['delete_time', 'product_id','img_id'];

    public function img()
    {
        return $this->belongsTo('Image','img_id','id');
    }

}