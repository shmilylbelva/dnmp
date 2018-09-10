<?php
/**
 * Created by shmilyelva
 * Date: 2018/9/6
 * Time: 下午10:06
 */

namespace app\api\controller\v1;

//use app\api\validate\DataValidate;
class Banner
{
    public function getBanner($id){
        $data = [
            'name' => 'shmilyelva',
            'id' => $id,
            'email' => 'thinkphp@qq.com',
            'class' => 'qwe'
        ];

        $validate = new \app\api\validate\DataValidate();
        $res = $validate->scene('false')->check($data);
        if(!$res){
            print_r($validate->getError());
        }
    }
}