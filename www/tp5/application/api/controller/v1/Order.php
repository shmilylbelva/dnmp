<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-30
 * Time: 11:33
 */

namespace app\api\controller\v1;

use app\api\validate\DataValidate;
use app\api\validate\PagingParameter;
use app\api\validate\PlaceOrder;
use app\lib\exception\OrderException;
use think\Controller;
use app\api\service\Token;
use app\api\service\Order as OrderService;
use app\api\model\Order as modelOrder;

class Order extends Controller
{
//    protected  $middleware = [
//        'ExclusiveScope' => ['only' => ['placeOrder']]
//    ];

    public function getSummaryByUser($page=1,$size=15)
    {
        (new PagingParameter())->goCheck();
        $uid = Token::getCurrentTokenVar('uid');
        $pagingOrders = modelOrder::getSummaryByUser($uid,$page,$size);
        if ($pagingOrders->isEmpty()) {
            return [
              'data' => [],
              'current_page' => $pagingOrders->currentPage()
            ];
        }
        $data = $pagingOrders->hidden(['snap_items','snap_address','prepay_id'])->toArray();
        return [
            'data' => $data,
            'current_page' => $pagingOrders->currentPage()
        ];
    }

    public function placeOrder()
    {
        (new PlaceOrder())->goCheck();
        $products = input('post.products/a');
        $uid = Token::getCurrentTokenVar('uid');
        $order = new OrderService();
        return $order->placeOrder($uid, $products);
    }


    public function getDetail($id) {
        (new DataValidate())->goCheck();
        $uid = Token::getCurrentTokenVar('uid');
        $detail = modelOrder::getDetail($uid,$id);
        if (!$detail) {
            throw new OrderException();
        }
        return $detail->hidden(['prepay_id']);
    }
}