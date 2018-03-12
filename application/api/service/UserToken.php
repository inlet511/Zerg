<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/9
 * Time: 16:07
 */

namespace app\api\service;

use app\api\model\User;
use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code)
    {
        //构造函数主要是组装请求链接地址
        $this->code=$code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'),$this->wxAppID,$this->wxAppSecret,$this->code);
    }

    //向微信服务器请求用户数据
    public function get()
    {
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result,true);
        if(empty($wxResult)){
            //这里属于服务器内部异常，不希望返回到客户端，因此没有返回BaseException
            throw new Exception('获取session_key及openID时异常，微信内部错误');
        }else{
            $loginFail = array_key_exists('errcode',$wxResult);
            if($loginFail){
                //调用失败
                $this->proccessLoginError($wxResult);
            }else{
                //调用成功
                return $this->grantToken($wxResult);
            }
        }
    }

    //颁发令牌
    private function grantToken($wxResult)
    {
        //拿到openid
        //数据库里看一下，这个openid是不是已经存在
        //如果存在，则不处理，如果不存在，新增一条记录
        //生成令牌，准备缓存数据，写入缓存
        //把令牌返回到客户端
        $openid = $wxResult['openid'];
        $user = User::getByOpenID($openid);
        if($user){
            $uid = $user->id;
        }else{
            $uid = $this->newUser($openid);
        }
        $cachedValue = $this->prepareCachedValue($wxResult,$uid);
        $token = $this->saveToCache($cachedValue);
        return $token;
    }


    private function saveToCache($cachedValue)
    {
        $key = self::generateToken();
        $value = json_encode($cachedValue);
        $lifespan = config('settings.token_lifespan');

        $request = cache($key,$value, $lifespan);
        if(!$request){
            throw new TokenException([
                    'msg'=>'服务器缓存异常',
                    'errorCode'=>10005
                ]);
        }
        return $key;
    }

    //缓存的key：令牌
    //缓存的value: wxResult（包括openid和session_key）， uid表示数据库生成这条记录的唯一标识, scope表示用户的身份和权限级别
    private function prepareCachedValue($wxResult,$uid){
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = ScopeEnum::User;
        return $cachedValue;
    }

    //增加一条用户记录
    private function newUser($openid)
    {
        $user = User::create([
           'openid'=>$openid
        ]);
        return $user->id;
    }

    //处理登录出错
    private function proccessLoginError($wxResult)
    {
        throw new WeChatException([
           'msg'=>$wxResult['errmsg'],
            'errorCode'=>$wxResult['errcode']
        ]);
    }
}