<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/8
 * Time: 15:36
 */

namespace app\api\model;

class Image extends BaseModel
{
    protected $hidden=['id','from','delete_time','update_time'];

    public function getUrlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }
}