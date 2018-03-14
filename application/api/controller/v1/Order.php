<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/11
 * Time: 19:23
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\OrderPlace;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;
use app\api\validate\Pagingparameter;
use app\api\model\Order as OrderModel;
use app\lib\exception\OrderException;

class Order extends BaseController
{
    // 用户在选择商品后，向API提交包含它所选择的商品的相关信息
    // API在接收到信息后，需要检查订单相关商品的库存量
    // 有库存：把订单数据存入数据库中， 下单成功了，返回客户端消息，告诉客户端可以支付了
    // 调用支付接口，进行支付
    // 还需要再次进行库存量检测
    // 服务器就可以调用微信的支付接口进行支付
    // 微信会返回一个支付结果（异步）
    // 成功：再次进行库存量检查
    // 成功：库存量的扣除，失败：（由微信服务器）返回一个支付失败的结果

    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope'=>['only'=>'getDetail,getSummaryByUser'],
    ];


    public function getSummaryByUser($page = 1, $size = 15)
    {
        (new Pagingparameter())->goCheck();
        $uid = TokenService::getCurrentUID();
        $pagingOrders = OrderModel::getSummaryByUser($uid, $page, $size);
        if ($pagingOrders->isEmpty()) {
            return [
                'data' => [],
                'current_page' => $pagingOrders->getCurrentPage()
            ];
        }
        $data = $pagingOrders->hidden(['snap_items','snap_address','prepay_id'])->toArray();
        return [
            'data' => $data,
            'current_page' => $pagingOrders->getCurrentPage()
        ];
    }

    public function getDetail($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $orderDetail = OrderModel::get($id);
        if(!$orderDetail)
        {
            throw new OrderException();
        }
        return $orderDetail->hidden(['prepay_id']);
    }

    public function placeOrder()
    {
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUID();
        $order = new OrderService();
        $status = $order->place($uid, $products);
        return $status;
    }


}