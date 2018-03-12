<?php
/**
 * Created by PhpStorm.
 * User: KenAn
 * Date: 2018/3/10
 * Time: 23:28
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\User as UserModel;
use app\api\service\Token as TokenService;
use app\api\validate\AddressNew;
use app\lib\exception\UserException;

class Address extends BaseController
{
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress']
    ];

    public function createOrUpdateAddress()
    {
        $validate = new AddressNew();
        $validate->goCheck();

        //根据Token获取uid
        //根据uid来查找用户数据，判断用户是否存在，如果不存在，抛出异常
        //获取用户从客户端提交来的地址信息
        //根据用户地址信息是否存在，从而判断是添加还是更新

        $uid = TokenService::getCurrentUID();

        //这里的get并不是我们定义的，是Model的内置方法
        $user = UserModel::get($uid);
        if(!$user){
            throw new UserException();
        }

        //伪代码
        $dataArray = $validate->getDataByRule(input('post.'));


        $userAddress = $user->address;
        if(!$userAddress){
            $user->address()->save($dataArray);
        }else
        {
            $user->address->save($dataArray);
        }

        return 'success';

    }
}