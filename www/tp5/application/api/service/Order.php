<?php
/**
 * Created by shmilyelva
 * Date: 2018-10-08
 * Time: 11:09
 */

namespace app\api\service;


use app\api\model\Address;
use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\Order as modelOrder;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;

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
        $this->products = $this->getProductsByOrder($oProducts)->visible(['id','price','stock','name','main_img_url']);
        $this->uid = $uid;
        $status = $this->getOrderStatus();
        if (!$status['pass']) {
            $status['order_id'] = -1;
            return $status;
        }
        //创建订单
        $snap = $this->snapOrder($status);
        $order = $this->createOrder($snap);
        $order['pass'] = true;
        return $order;

    }

    private function createOrder($snap)
    {
        try {
            $data['user_id'] = $this->uid;
            $data['order_no'] = $this->makeOrderNo();
            $data['total_price'] = $snap['orderPrice'];
            $data['total_count'] = $snap['totalCount'];
            $data['snap_img'] = $snap['snapImg'];
            $data['snap_name'] = $snap['snapName'];
            $data['snap_address'] = $snap['snapAddress'];
            $data['snap_items'] = json_encode($snap['pStatus']);
            $data['create_time'] = time();
            $order = modelOrder::createOrder($data);
            $orderID = $order->id;
            foreach ($this->oProducts as &$p) {
                $p['order_id'] = $orderID;
            }
            $OrderProduct= new OrderProduct();
            $OrderProduct->saveAll($this->oProducts);
            return [
                'order_no' => $data['order_no'],
                'order_id' => $orderID,
                'create_time' => $data['create_time'],
            ];
        }
        catch (\Exception $e){
            throw $e;

        }

    }

    public static function makeOrderNo(){
        $yCode = array('A','B','C','D','E','F','G','H','I','J');
        return $yCode[intval(date('Y')) - 2018].strtoupper(dechex(date('m'))).date('d').substr(time(),-5).substr(microtime(),2,5).sprintf('%02d',rand(0,99));

    }

    private function snapOrder($status)
    {
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus' => [],
            'snapAddress' => '',
            'snapName' => '',
            'snapImg' => ''
        ];
        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapName'] = $this->products[0]['name'];
        $snap['snaImg'] = $this->products[0]['main_img_url'];
        if (count($this->products) > 1) {
            $snap['snapName'] .= '等';
        }
        return $snap;
    }

    private function getUserAddress()
    {
        $userAddress = Address::where('user_id', '=', $this->uid)->find()->toArray();
        if (!$userAddress) {
            throw new UserException([
                'msg' => '用户收货地址不存在',
                'errorCode' => '60001'
            ]);
        }
        return $userAddress;
    }

    //根据订单查找真实商品信息
    private function getProductsByOrder($oProducts)
    {
        $oPIDs = [];
        foreach ($oProducts as $item) {
            array_push($oPIDs, $item['product_id']);
        }
        $result = Product::getProductById($oPIDs);
        return $result;

    }

    private function getOrderStatus()
    {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatusArray' => []//订单详细信息
        ];
        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus($oProduct['product_id'], $oProduct['count'], $this->products);;
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['count'];
            array_push($status['pStatusArray'], $pStatus);
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