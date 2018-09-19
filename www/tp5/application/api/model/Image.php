<?php

namespace app\api\model;


class Image extends Base
{
    //
    protected $hidden = ['delete_time','update_time'];
    public function getUrlAttr($value,$data)
    {
        $prefix = config('setting.img_prefix_goods');
        return $this->prefixImgUrl($value,$data,$prefix);

    }
}
