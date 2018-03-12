<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/8
 * Time: 17:44
 */

namespace app\api\model;


class Product extends BaseModel
{
    protected $hidden = ['id','pivot','create_time','delete_time','update_time','from'];


    //读取器
    public function getMainimgurlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }

    //定义关联
    //详情图片（多个）
    public function imgs(){
        return $this->hasMany('ProductImage','product_id','id');
    }

    //商品属性
    public function properties(){
        return $this->hasMany('ProductProperty','product_id','id');
    }


    //定义方法

    public static function getMostRecent($count)
    {
        $products = self::limit($count)
            ->order('create_time desc')
            ->select();

        return $products;
    }

    public static function getAllInCategory($categoryID){
        $products = self::where('category_id','=',$categoryID)->select();
        return $products;
    }

    public static function getDetail($productID){
        $product = self::with([
            'imgs'=>function($query){
                $query->with(['url'])->order('order','asc');
            }
        ])
            ->with(['properties'])
            ->where('id','=',$productID)
            ->find();
        return $product;
    }
}