<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-20
 * Time: 9:42
 */

namespace app\api\validate;


class ThemeValidate extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|idsCheck'
    ];
    protected $message = [
        'ids.idsCheck' => 'ids参数必须为以逗号分隔的多个正整数'
    ];


    protected function idsCheck($value)
    {
        $array = explode(',',$value);
        if (empty($array)){
            return false;
        }
        foreach($array as $v){
            if (!$this->isPositiveInteger($v)){
                return false;
            }
        }
        return true;
    }
}