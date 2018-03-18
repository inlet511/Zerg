<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/18
 * Time: 21:42
 */

namespace app\api\validate;


class AppTokenGet extends BaseValidate
{
    protected $rule = [
        'ac'=>'require|isNotEmpty',
        'se'=>'require|isNotEmpty'
    ];

}