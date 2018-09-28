<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-13
 * Time: 15:09
 */

namespace app\api\model;

use think\Model;

class BannerItem extends Base
{
    protected $hidden = ['delete_time','update_time'];
    public function img()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}