<?php

namespace app\api\controller\v1;
use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\BannerMissException;

class Banner{
    /**
     * 获取指定的id的banner信息
     * @url /banner/:id
     * @http GET
     * @id banner的id号
     */
    public function getBanner($id){
        (new IDMustBePositiveInt())->goCheck();

        $banner = BannerModel::getBannerById($id);

        if(!$banner){
            throw new BannerMissException(
                [
                    'msg'=>'请求的banner不存在',
                    'errorCode'=>40000
                ]
            );
        }
        return $banner;
    }
}