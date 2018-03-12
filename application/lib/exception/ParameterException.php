<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/7
 * Time: 22:44
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 10002;
}