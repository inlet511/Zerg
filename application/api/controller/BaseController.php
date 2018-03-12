<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/11
 * Time: 21:15
 */

namespace app\api\controller;


use app\api\service\Token;
use think\Controller;

class BaseController extends Controller
{
    protected function checkPrimaryScope(){
        Token::needPrimaryScope();
    }

    protected function checkExclusiveScope(){
        Token::needExclusiveScope();
    }
}