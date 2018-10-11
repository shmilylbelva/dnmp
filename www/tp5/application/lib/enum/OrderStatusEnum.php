<?php
/**
 * Created by shmilyelva
 * Date: 2018-10-10
 * Time: 16:45
 */

namespace app\lib\enum;


class OrderStatusEnum
{
    const UNPAID = 1;//待支付
    const PAID = 2;//已支付
    const DELIVERED = 3;//已发货
    const PAID_BUT_OUT_OF = 4;//已支付，但库存不足
}