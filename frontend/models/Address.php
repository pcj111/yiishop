<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property int $id
 * @property int $member_id 用户Id
 * @property string $name 名称
 * @property string $province 省
 * @property string $city 市
 * @property string $area 区
 * @property string $address 详细地址
 * @property string $phone 手机
 * @property string $default_status 默认地址
 */
class Address extends \yii\db\ActiveRecord
{
    public $remember;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'name', 'province', 'city', 'area', 'address', 'phone'], 'required'],
            [['member_id', 'default_status'], 'integer'],
            [['name', 'province', 'city', 'area', 'phone'], 'string', 'max' => 30],
            [['address'], 'string', 'max' => 255],
            ['remember','safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '用户Id',
            'name' => '名称',
            'province' => '省',
            'city' => '市',
            'area' => '区',
            'address' => '详细地址',
            'phone' => '手机',
            'default_status' => '默认地址',
        ];
    }
}
