<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/7
 * Time: 19:46
 */

namespace app\lib\exception;


class BannerMissException extends BaseException
{
    public $code = 404;
    public $msg = '请求的Banner不存在';
    public $errorCode = 40000;
}