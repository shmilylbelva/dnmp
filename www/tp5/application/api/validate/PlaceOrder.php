<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-30
 * Time: 16:53
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class PlaceOrder extends BaseValidate
{
    protected $rule = [
        'products' => 'checkProducts'
    ];

    protected $singleRule = [
      'product_id' => 'require|isPositiveInteger',
      'count' => 'require|isPositiveInteger',
    ];

    protected function checkProducts($values)
    {
        if (empty($values) || !is_array($values)) {
            throw new ParameterException([
                'msg' => '商品参数错误'
            ]);
        }
        foreach ($values as $value) {
            $this->checkProduct($value);
        }
        return true;
    }

    private  function checkProduct($value){
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->check($value);
        if (!$result) {
            throw new ParameterException([
               'msg' => '商品列表参数错误'
            ]);
        }
    }
}