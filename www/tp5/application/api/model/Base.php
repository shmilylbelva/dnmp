<?php

namespace app\api\model;

use think\Model;

class Base extends Model
{
    //
    public function prefixImgUrl($value,$data,$prefix)
    {
        if ($data['from'] == 1){//本地
            return $prefix.$value;
        }else{
            return $value;
        }
    }
}
