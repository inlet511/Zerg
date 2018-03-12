<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/7
 * Time: 19:44
 */

namespace app\lib\exception;


use think\Exception;


class BaseException extends Exception
{

    public function __construct($params=[])
    {
        if(!is_array($params)){
            throw new Exception('参数必须是数组');
        }
        if(array_key_exists('code',$params)){
            $this->code = $params['code'];
        }
        if(array_key_exists('msg',$params)){
            $this->msg = $params['msg'];
        }
        if(array_key_exists('errorCode',$params)){
            $this->errorCode = $params['errorCode'];
        }

    }

    //HTTP 状态码
    public $code = 400;

    //错误具体信息
    public $msg = '参数错误';

    //自定义的错误码
    public $errorCode = 10000;
}