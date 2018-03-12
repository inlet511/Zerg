<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/11
 * Time: 0:15
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = 60000;

}