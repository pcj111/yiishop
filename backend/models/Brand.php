<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "Brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property string $logo
 * @property integer $sort
 * @property integer $is_deleted
 */
class Brand extends \yii\db\ActiveRecord
{
    public $imgFile;//图片属性
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['intro'], 'string'],
            [['sort', 'is_deleted'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['logo'], 'string', 'max' => 255],
            ['imgFile','file','extensions'=>['png','jpg','gif']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'intro' => '简介',
            'logo' => 'logo图片',
            'sort' => '排序',
            'is_deleted' => '状态0正常1删除',
            'imgFile'=>'上传logo',
        ];
    }
}
