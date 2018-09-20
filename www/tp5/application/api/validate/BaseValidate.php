<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-07
 * Time: 14:14
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Validate;

class BaseValidate extends Validate
{

    public function goCheck(){
        $param = request()->param();
        $result = $this->check($param);
        if(!$result){
            throw new ParameterException([
                'msg' => $this->error
            ]);
        }else{
            return true;
        }
    }
    protected function isPositiveInteger($value, $rule='', $data='', $field='')
    {

        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        return false;
    }
}