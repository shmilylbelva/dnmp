<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-20
 * Time: 14:50
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\model\Product as modelProduct;
use app\lib\exception\ProductException;

class Product
{
    public function getRecent($count=15)
    {
        (new Count())->goCheck();
        $result = modelProduct::getRecent($count)->hidden(['summary','stock'])->append(['from']);
        if ($result->isEmpty()){
            throw new ProductException();
        }
        return $result;
    }
}