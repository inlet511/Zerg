<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/11
 * Time: 19:09
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg = '权限不够';
    public $errorCode = 10001;
}