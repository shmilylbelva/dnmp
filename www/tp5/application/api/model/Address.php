<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-28
 * Time: 13:41
 */

namespace app\api\model;


class Address extends Base
{
    protected $hidden = ['id','delete_time','user_id'];
    protected $table = 'user_address';
}