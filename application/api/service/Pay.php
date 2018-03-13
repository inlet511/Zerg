<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/12
 * Time: 22:40
 */

namespace app\api\service;


use app\api\model\Order as OrderModel;
use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;

class Pay
{
    private $orderID;
    private $orderNo;

    function __construct($orderID)
    {
        if (!$orderID) {
            throw new Exception('订单号不允许为空');
        }
        $this->orderID = $orderID;
    }

    public function pay()
    {
        //订单号可能根本不存在
        //订单号确实是存在的，但是订单号和当前用户是不匹配的
        //订单有可能已经被支付过了
        //进行库存量检测
        $this->validateOrder();
        $orderService = new Order();
        $status = $orderService->checkOrderStock($this->orderID);
        if(!$status['pass'])
        {
            return $status;
        }

    }

    //下预订单
    private function makeWxPreOrder()
    {
        //openid
        $openid = Token::getCurrentTokenVar('openid');
        if(!$openid)
        {
            throw new TokenException();
        }

    }

    private function validateOrder()
    {
        $order = OrderModel::where('id', '=', $this->orderID)
            ->find();
        if (!$order)
            throw new OrderException();

        if (!Token::isValidOperate($order->user_id)) {
            throw new TokenException([
                'msg'=>'订单与用户不匹配',
                'errorCode'=>10003
            ]);
        }
        if($order->status !=OrderStatusEnum::UNPAID)
        {
            throw new OrderException([
                'msg'=>'订单已经支付',
                'errorCode'=>80003,
                'code'=>400
            ]);
        }
        $this->orderNo = $order->order_no;
        return true;
    }
}