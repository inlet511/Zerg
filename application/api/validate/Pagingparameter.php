<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/14
 * Time: 8:42
 */

namespace app\api\validate;


class Pagingparameter extends BaseValidate
{
    protected $rule = [
        'page' => 'isPositiveInteger',
        'size' => 'isPositiveInteger',
    ];

    protected $message = [
        'page'=>'分页参数必须是正整数',
        'size'=>'分页参数必须是正整数',
    ];


}