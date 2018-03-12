<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/7
 * Time: 18:59
 */

namespace app\api\model;

class Banner extends BaseModel
{
    protected $hidden = ['id','delete_time','update_time'];

    //使用hasMany关联Banner和BannerItem模型
    public function items(){
        return $this->hasMany('BannerItem','banner_id','id');
    }

    public static function getBannerById($id)
    {
        return self::with(['items','items.img'])->find($id);
    }
}