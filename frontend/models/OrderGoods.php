<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_goods".
 *
 * @property int $id
 * @property int $order_id 订单id
 * @property int $good_id 商品id
 * @property string $good_name 商品名称
 * @property string $logo 商品图片
 * @property string $price 价格
 * @property int $amount 数量
 * @property string $total 小计
 */
class OrderGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'good_id', 'good_name', 'logo', 'price', 'amount', 'total'], 'required'],
            [['order_id', 'good_id', 'amount'], 'integer'],
            [['price', 'total'], 'number'],
            [['good_name', 'logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '订单id',
            'good_id' => '商品id',
            'good_name' => '商品名称',
            'logo' => '商品图片',
            'price' => '价格',
            'amount' => '数量',
            'total' => '小计',
        ];
    }
}
