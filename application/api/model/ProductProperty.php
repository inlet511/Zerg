<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/10
 * Time: 21:07
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = ['product_id','delete_time','id'];
}