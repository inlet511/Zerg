<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/13
 * Time: 11:37
 */

namespace app\lib\enum;


class OrderStatusEnum
{
    const UNPAID = 1;
    const PAID = 2;
    const DELIVERED = 3;
    const PAID_BUT_OUT_OF_STORAGE = 4;
}