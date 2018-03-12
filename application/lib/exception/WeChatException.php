<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/9
 * Time: 21:04
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 400;
    public $msg = '微信服务器接口调用失效';
    public $errorCode = 999;

}