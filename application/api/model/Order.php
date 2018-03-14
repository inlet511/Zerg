<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/12
 * Time: 15:28
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id', 'delete_time', 'update_time'];
    protected $autoWriteTimestamp = true;

    public function getSnapItemsAttr($value){
        if(empty($value))
        {
            return null;
        }
        return json_encode($value);
    }
    public function getSnapAddressAttr($value){
        if(empty($value))
        {
            return null;
        }
        return json_encode($value);
    }

    public static function getSummaryByUser($uid, $page = 1, $size = 15)
    {
        $pageingData = self::where('user_id', '=', $uid)
            - order('create_time desc')
                ->paginate($size, true, ['page' => $page]);
        return $pageingData;
    }
}