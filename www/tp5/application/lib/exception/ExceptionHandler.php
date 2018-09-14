<?php
/**
 * Created by shmilyelva
 * Date: 2018/9/11
 * Time: 上午9:48
 */

namespace app\lib\exception;


use Exception;
use think\exception\Handle;
use think\facade\Config;
use think\facade\Log;


class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    public function render(Exception $e)
    {
        //如果自定义异常
        if ($e instanceof BaseException){
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }else{
            //调试模式是否开启
            if (Config::get('app.app_debug')){
                return parent::render($e);
            }else{
                $this->code = 500;
                $this->msg = '服务器异常';
                $this->errorCode = 999;
                $this->recordErrorLog($e);
            }

        }
        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => request()->url()
        ];
        return json($result,$this->code);
    }

    private function recordErrorLog(Exception $e){
        Log::write($e->getMessage(),'error');
    }
}