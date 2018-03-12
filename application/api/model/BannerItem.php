<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/8
 * Time: 15:16
 */

namespace app\api\model;


class BannerItem extends BaseModel
{
    protected $hidden = ['id','img_id','banner_id','delete_time','update_time'];
    public function img(){
        return $this->belongsTo('Image','img_id','id');
    }
}