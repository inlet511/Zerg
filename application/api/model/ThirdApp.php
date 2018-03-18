<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/18
 * Time: 21:47
 */

namespace app\api\model;


class ThirdApp extends BaseModel
{
    public static function check($ac,$se)
    {
        $app = self::where('app_id','=',$ac)
            ->where('app_secret','=',$se)
            ->find();
        return $app;
    }
}