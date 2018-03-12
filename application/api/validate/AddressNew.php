<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/10
 * Time: 23:30
 */

namespace app\api\validate;


class AddressNew extends BaseValidate
{
    protected $rule=[
        'name'=>'require|isNotEmpty',
        'mobile'=>'require|isMobile',
        'province'=>'require|isNotEmpty',
        'city'=>'require|isNotEmpty',
        'country'=>'require|isNotEmpty',
        'detail'=>'require|isNotEmpty',
    ];
}