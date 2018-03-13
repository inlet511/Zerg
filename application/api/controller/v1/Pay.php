<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/12
 * Time: 22:32
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\WxNotify;
use app\api\validate\IDMustBePositiveInt;
use app\api\service\Pay as PayService;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope'=>['only'=>'getPreOrder']
    ];

    //发送预订单请求
    public function getPreOrder($id='')
    {
        (new IDMustBePositiveInt())->goCheck();
        $pay = new PayService($id);
        return $pay->pay();
    }

    public function receiveNotify()
    {
        //通知频率为15/15/30/180/1800/1800/1800/3600，单位秒
        //1. 检测库存量
        //2. 更新订单状态
        //3. 减库存
        //4. 如果成功处理，我们返回微信成功处理的信息，否则需要返回没有成功处理

        //特点：post 微信提供的是xml格式 url地址不能用？携带参数
        $notify = new WxNotify();
        $notify->Handle();
    }
}