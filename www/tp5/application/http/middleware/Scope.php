<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-29
 * Time: 17:44
 */

namespace app\http\middleware;

use app\api\service\Token as TokenService;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;

class Scope
{
    public function handle($request, \Closure $next)
    {
        $scope = TokenService::getCurrentTokenVar('scope');
        if (!$scope) {
            throw new TokenException();
        }
        if ($scope < 17) {
            throw new ForbiddenException();
        }
        return $next($request);
    }

}