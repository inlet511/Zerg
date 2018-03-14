<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/8
 * Time: 20:18
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule=[
        'ids'=>'require|checkIDs'
    ];

    protected $message=[
        'ids'=>'ids 必须是以逗号分隔的多个正整数'
    ];

    protected function checkIDs($value, $rule='', $data='', $field=''){
        $values = explode(',',$value);
        if(empty($values)){
            return false;
        }
        foreach ($values as $item) {
            if(!$this->isPositiveInteger($item)){
                return false;
            }
        }
        return true;
    }

}