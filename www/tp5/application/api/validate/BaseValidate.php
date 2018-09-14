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
}