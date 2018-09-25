<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018-09-06
 * Time: 16:05
 */

namespace app\api\controller\v1;

use app\api\validate\DataValidate;
use app\api\model\Banner as modelBanner;
use app\lib\exception\MissException;

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
        (new DataValidate())->batch()->scene('test')->goCheck();
        $result = modelBanner::getBannerById($id);
        if (!$result) {
            throw new MissException();
        }

        return $result;
    }
}