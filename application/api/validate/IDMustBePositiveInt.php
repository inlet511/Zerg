<?php
namespace app\api\validate;

class IDMustBePositiveInt extends BaseValidate
{
    protected $rule=[
        'id' => 'require|isPositiveInteger',
    ];

    protected $message=[
        'id' => 'ID必须是正整数'
    ];
}