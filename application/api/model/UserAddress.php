<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/11
 * Time: 14:30
 */

namespace app\api\model;


class UserAddress extends BaseModel
{
    protected $hidden = ['id','delete_time','user_id'];
}