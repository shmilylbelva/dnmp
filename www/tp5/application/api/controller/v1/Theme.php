<?php

namespace app\api\controller\v1;

use app\api\validate\DataValidate;
use app\api\validate\ThemeValidate;
use app\api\model\Theme as modelTheme;
use app\lib\exception\ThemeException;

class Theme
{
    /**
     * 获取主题
     *
     * @return \think\Response
     */
    public function getSimpleList($ids='')
    {
        //
        (new ThemeValidate())->goCheck();
        $result = modelTheme::getThemeByIds($ids);
        if ($result->isEmpty()){
            throw new ThemeException();
        }
        return $result;
    }

    /**
     * 获取某个主题下的列表
     * @param $id
     */
    public function getComplexOne($id){
        (new DataValidate())->goCheck();
        $result = modelTheme::getThemeListById($id);
        if ($result->isEmpty()){
            throw new ThemeException();
        }
        return $result;
    }

}
