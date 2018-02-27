<?php
namespace backend\controllers;

use backend\models\ArticleCategory;
use yii\data\Pagination;



class ArticleCategoryController extends \yii\web\Controller{
    //文章分类列表
    public function actionIndex()
    {
        //创建查询对象
        $query = \backend\models\ArticleCategory::find();
        //分页
        $pager=new \yii\data\Pagination();
        $pager->totalCount=$query->count();
        $pager->defaultPageSize=5;

        $categories=$query->where(['is_deleted'=>0])->offset($pager->offset)->limit($pager->limit)->all();

        return $this->render('index', ['categories' => $categories,'pager'=>$pager]);
    }

//文章分类添加
    public function actionAdd()
    {

        $model = new \backend\models\ArticleCategory();
        $request = \Yii::$app->request;

        if ($request->isPost) {
            $model->load($request->post());
            //再次验证数据
            if ($model->validate()) {
                $model->is_deleted = 0;
                $model->save();
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['article-category/index']);
            }
        }


        return $this->render('form', ['model' => $model]);
    }

//文章分类修改
    public function actionEdit($id)
    {

        $model = \backend\models\ArticleCategory::findOne(['id' => $id]);

        $request = \Yii::$app->request;

        if ($request->isPost) {
            $model->load($request->post());
            //再次验证数据
            if ($model->validate()) {
                $model->is_deleted = 0;
                $model->save();
                \Yii::$app->session->setFlash('primary', '修改成功');
                return $this->redirect(['article-category/index']);
            }
        }
        return $this->render('form', ['model' => $model]);
    }

//文章分类删除
    public function actionDelete($id)
    {
        //查询出数据
        $model = \backend\models\ArticleCategory::findOne(['id' => $id]);
        //修改数据
        if (!$model->is_deleted) {
            $model->is_deleted = 1;
            $model->save();
        }
        \Yii::$app->session->setFlash('warning', '删除成功');
        return $this->redirect(['article-category/index']);
    }

}