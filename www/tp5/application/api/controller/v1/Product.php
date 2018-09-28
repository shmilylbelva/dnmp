<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-20
 * Time: 14:50
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\model\Product as modelProduct;
use app\api\validate\DataValidate;
use app\lib\exception\ProductException;
use app\lib\exception\CategoryException;

class Product
{

    /**
     * 最新商品
     * @param int $count
     * @return mixed
     */
    public function getRecent($count = 15)
    {
        (new Count())->goCheck();
        $result = modelProduct::getRecent($count);
        $isEmpty = $result->hidden(['summary', 'stock'])->append(['from']);
        if ($result->isEmpty()) {
            throw new ProductException();
        }
        return $isEmpty;
    }

    public function getAllInCategory($id)
    {
        (new DataValidate())->goCheck();
        $result = modelProduct::getAllInCategory($id);
        if ($result->isEmpty()) {
            throw new CategoryException();
        }
        return $result->hidden(['summary']);
    }

    public function detail($id)
    {
        (new DataValidate())->goCheck();
        $result = modelProduct::detail($id);
        if (!$result){
            throw new ProductException();
        }
        return $result;
    }
}