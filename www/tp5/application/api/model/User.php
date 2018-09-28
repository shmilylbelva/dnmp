<?php
/**
 * Created by shmilyelva
 * Date: 2018/9/26
 * Time: 下午8:27
 */

namespace app\api\model;


class User extends Base
{
    protected $hidden = [
        'delete_time','update_time','create_time'
    ];

    public function address(){
        return $this->hasOne('Address','user_id','id');
    }

    public static function getUserByOpenId($openid){
        return self::where('openid','=',$openid)->find();
    }

    public static function getUserById($id)
    {
        return self::get($id);
    }

    public static function addUser($openid){
        return self::create(['openid' => $openid]);
    }
}