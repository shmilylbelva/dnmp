<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-28
 * Time: 12:00
 */

namespace app\api\controller\v1;

use app\api\validate\AddressValidate;
use app\api\service\Token as TokenService;
use app\api\model\User as modelUser;

use app\lib\exception\UserException;
use app\lib\exception\SuccessException;
use think\Controller;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use app\lib\enum\ScopeEnum;

class Address extends Controller
{
    //前置方法  即将废除
//    protected $beforeActionList  = [
//        'checkPrimaryScope' => ['only' => ['saveAddress']]
//    ];
//
//    protected function checkPrimaryScope()
//    {
//        $scope = TokenService::getCurrentTokenVar('scope');
//        if (!$scope){
//            throw new TokenException();
//        }
//        if ($scope < ScopeEnum::User) {
//            throw new ForbiddenException();getCurrentUid
//        }
//        return true;
//    }

//中间件
//    protected  $middleware = [
//    'Scope' => ['only' => ['saveAddress']]
//];

    public function saveAddress()
    {
        $validate = new AddressValidate();
        $validate->goCheck();
        /**
         * 根据Token获取uid
         * 用uid查找用户是否存在
         * 获取用户提交的数据
         * 判断数据是否已存在，不存在则添加，存在则更新
         */
        $uid = TokenService::getCurrentTokenVar('uid');
        $user = modelUser::getUserById($uid);
        if (!$user) {
            throw new UserException();
        }
        $filterData = $validate->getDataByRule(request()->post());
        if (!$user->address) {//新增
            $user->address()->save($filterData);
        } else {
            $user->address->save($filterData);
        }
        return json(new SuccessException())->code(201);//http状态码
    }
}