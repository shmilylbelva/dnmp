<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-30
 * Time: 15:41
 */

namespace app\http\middleware;

use app\api\service\Token as TokenService;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use app\lib\enum\ScopeEnum;

//只有用户才能访问
class ExclusiveScope
{
    public function handle($request, \Closure $next)
    {
        $scope = TokenService::getCurrentTokenVar('scope');
        if (!$scope) {
            throw new TokenException();
        }
        if ($scope != ScopeEnum::User) {
            throw new ForbiddenException();
        }
        return $next($request);
    }
}