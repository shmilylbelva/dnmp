<?php
/**
 * Created by shmilyelva
 * Date: 2018-10-08
 * Time: 11:09
 */

namespace app\api\service;


use app\api\model\Product;
use app\lib\exception\OrderException;

class Order
{
    //订单商品列表
    protected $oProducts;
    //数据库信息
    protected $products;
    protected $uid;

    public function placeOrder($uid, $oProducts)
    {
        //对比oProducts和products
        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrder($oProducts);
        $this->uid = $uid;

    }

    //根据订单查找真实商品信息
    private function getProductsByOrder($oProducts)
    {
        $oPIDs = [];
        foreach ($oProducts as $item) {
            array_push($oPIDs, $item['product_id']);
        }
        return Product::getProductById($oPIDs);

    }

    private function getOrderStatus()
    {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'pStatusArray' => []//订单详细信息
        ];
        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus($oProduct['product_id'], $oProduct['count'], $this->products);;
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            array_push($status['pStatusArray'],$pStatus);
        }
        return $status;

    }

    private function getProductStatus($oPID, $oCount, $products)
    {
        $pIndex = -1;
        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'totalPrice' => 0//单个商品的总价
        ];
        for ($i = 0; $i < count($products); $i++) {
            if ($oPID == $products[$i]['id']) {
                $pIndex = $i;
            }
        }
        if ($pIndex == -1) {
            throw new OrderException([
                'msg' => 'id为' . $oPID . '的商品不存在，创建订单失败'
            ]);
        }
        $product = $products[$pIndex];
        $pStatus['id'] = $product['id'];
        $pStatus['name'] = $product['name'];
        $pStatus['count'] = $oCount;
        $pStatus['totalPrice'] = $product['price'] * $oCount;
        if ($product['stock'] - $oCount >= 0) {
            $pStatus['haveStock'] = true;
        }
        return $pStatus;
    }


}