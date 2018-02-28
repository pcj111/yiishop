<?php
namespace backend\models;


use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Article extends ActiveRecord{

    public function attributeLabels()
    {
        return [
            'name'=>'名称',
            'intro'=>'简介',
            'article_category_id'=>'文章分类',
            'sort'=>'排序',
            'is_deleted'=>'状态',
            'create_time'=>'创建时间',
        ];
    }

    public function rules()
    {
        return [
            [['name','intro','article_category_id','sort'],'required']
        ];
    }

    //链表查询
    public function getarticleCatagory(){
       return $this->hasOne(ArticleCategory::className(),['id'=>'article_category_id']);
    }
    //显示下拉框
    public static function getName(){
        $article = ArticleCategory::find()->all();
        return ArrayHelper::map($article,'id','name');
    }
}