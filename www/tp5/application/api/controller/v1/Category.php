<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-21
 * Time: 11:59
 */

namespace app\api\controller\v1;

use app\api\model\Category as categoryModel;
use app\lib\exception\CategoryException;

class Category
{
    /**
     * 全部分类
     */
    public function getCategories(){
        $result = categoryModel::getCategories();
        if ($result->isEmpty()){
            throw new CategoryException();
        }
        return $result;
    }
}