<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/10
 * Time: 21:05
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['img_id','delete_time','product_id'];

    public function url(){
        return $this->belongsTo('Image','img_id','id');
    }
}