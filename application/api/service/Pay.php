<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/12
 * Time: 22:40
 */

namespace app\api\service;


use app\api\model\Product;
use think\Exception;

class Pay
{
    private $orderID;
    private $orderNo;

    function __construct($orderID)
    {
        if(!$orderID)
        {
            throw new Exception('订单号不允许为空');
        }
        $this->orderID = $orderID;
    }

    public function pay()
    {

    }
}