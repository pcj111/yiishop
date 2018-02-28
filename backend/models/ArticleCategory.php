<?php
namespace backend\models;

use Yii;

/**
 * This is the model class for table "article-category".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $sort
 * @property integer $is_deleted
 */
class ArticleCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sort', ], 'required'],
            [['intro'], 'string'],
            [['sort', 'is_deleted'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章分类名称',
            'intro' => '文章分类简介',
            'sort' => '文章分类排序',
            'is_deleted' => 'Is Deleted',

        ];
    }

    /** 获取全部分类
     * @return array
     */

}