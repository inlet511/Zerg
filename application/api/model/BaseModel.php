<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/8
 * Time: 17:05
 */

namespace app\api\model;
use think\Model;

class BaseModel extends Model
{
    protected function prefixImgUrl($value,$data){
        if($data['from']==1)
            return config('settings.img_prefix').$value;
        else
            return $value;
    }
}