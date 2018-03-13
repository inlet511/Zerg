<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/9
 * Time: 22:27
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    public static function generateToken(){
        //32个字符组成一组随机字符串
        $randChars = getRandChars(32);
        //时间戳
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //salt
        $salt = config('secure.token_salt');

        return md5($randChars.$timestamp.$salt);
    }


    public static function getCurrentTokenVar($key){
        $token = Request::instance()
            ->header('token');
        //从本地缓存查找token对应的信息
        $vars = Cache::get($token);
        if(!$vars){
            throw new TokenException();
        }else{
            //这里判断是否是数组，是为了兼容更多的缓存方法(redis等)
            if(!is_array($vars))
            {
                $vars = json_decode($vars,true);
            }
            if(array_key_exists($key,$vars)){
                return $vars[$key];
            }else{
                //没有必要返回给客户端的异常都使用tp5的Exception
                throw new Exception('尝试获取的Token变量并不存在');
            }
        }
    }

    //获取当前的用户ID(根据用户传入的从本地缓存种读取)
    public static function getCurrentUID(){
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    public static function needPrimaryScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if($scope) {
            if ($scope >= ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        }else
        {
            throw new TokenException();
        }
    }

    public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if($scope) {
            if ($scope == ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        }else
        {
            throw new TokenException();
        }
    }

    public static function isValidOperate($checkedUID){
        if(!$checkedUID)
            throw new Exception('检查UID时必须传入一个UID');
        $currentUID = self::getCurrentUID();
        if($currentUID == $checkedUID)
        {
            return true;
        }
        return false;
    }

}