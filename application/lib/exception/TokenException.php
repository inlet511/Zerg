<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/10
 * Time: 15:54
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'Token已过期或无效';
    public $errorCode = 10001;
}