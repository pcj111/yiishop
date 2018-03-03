<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string $name 商品名称
 * @property string $sn 商品名称
 * @property string $logo logo图片
 * @property int $goods_category_id 商品分类id
 * @property int $brand_id 品牌分类
 * @property string $market_price 市场价格
 * @property string $shop_price 商品价格
 * @property int $stock 库存
 * @property int $is_on_sale 是否在售
 * @property int $status 状态
 * @property int $sort 排序
 * @property int $create_time 添加时间
 * @property int $view_times 浏览次数
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'goods_category_id', 'brand_id'], 'required'],
            [['goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort', 'create_time', 'view_times'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name'], 'string', 'max' => 20],
            [['logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'sn' => '商品名称',
            'logo' => 'logo图片',
            'goods_category_id' => '商品分类',
            'brand_id' => '品牌分类',
            'market_price' => '市场价格',
            'shop_price' => '商品价格',
            'stock' => '库存',
            'is_on_sale' => '是否在售',
            'status' => '状态',
            'sort' => '排序',
            'create_time' => '添加时间',
            'view_times' => '浏览次数',
        ];
    }
    //显示下拉框
    public static function getName(){
          $brand = Brand::find()->all();
        return ArrayHelper::map($brand,'id','name');
    }
    public function getBrand(){
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }
    //分类名
    public function getGoodsCategory(){
        return $this->hasOne(GoodsCategory::className(),['id'=>'goods_category_id']);
    }

    //货号
    public function addSn(){
        $number = GoodsDayCount::findOne(['day'=>date('Y-m-d',time())]);
        if ($number){
            $number->count=$number->count+1;
            $number->save();
        }else{
            $number = new GoodsDayCount();
            $number->day = date('Ymd',time());
            $number->count=1;
            $number->save();
        }
        return date('Ymd', time()).sprintf("%05d", $number->count);
    }

}
