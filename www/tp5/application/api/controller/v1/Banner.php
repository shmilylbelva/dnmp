<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018-09-06
 * Time: 16:05
 */

namespace app\api\controller\v1;

use app\api\validate\DataValidate;
use app\lib\exception\MissException;
use app\api\model\BannerItem as modelBanner;
class Banner
{
    /**
     * 获取指定id的banner信息
     * @url /banner/:id
     * @http GET
     * @param $id abnner的id号
     */
    public function getBanner($id)
    {
//       $validate = new DataValidate;
//       if($validate->scene('test')->goCheck()){
       if((new DataValidate())->batch()->scene('test')->goCheck()){
//           print_r(__DIR__);
           $result = modelBanner::get($id);
//           $result = modelBanner::getBannerById($id);
           if (!$result){
               throw new MissException();
           }
           return json($result);
       }else{
//           throw new MissException([
//               'msg' => '请求banner不存在',
//               'errorCode' => 40000
//           ]);
       }

    }
}