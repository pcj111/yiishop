<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/27 0027
 * Time: 15:28
 */

namespace backend\controllers;



use backend\models\Article;
use backend\models\ArticleDetail;
use yii\data\Pagination;
use yii\web\Controller;

class ArticleController extends Controller
{
    //显示页面
   public function actionIndex(){
       //实例化分页工具
       $paper  = new Pagination();
       //总条数
       $paper->totalCount = Article::find()->count();
       //显示5条记录
       $paper->defaultPageSize=5;
       $query = Article::find()->where(['is_deleted'=>0]);
       $rows = $query->offset($paper->offset)->limit($paper->limit)->all();
       return $this->render('index',['rows'=>$rows,'paper'=>$paper]);
   }
   //添加
    public function actionAdd(){
       $model = new Article();
       $content = new ArticleDetail();
       $request = \Yii::$app->request;
       if ($request->isPost) {
           //都自动加载
           $model->load($request->post());
           $content->load($request->post());
           if ($model->validate() && $content->validate()) {
               $content->save();
               $model->create_time = time();
               $model->is_deleted = 0;
               $model->save();
               \Yii::$app->session->setFlash('success', '添加成功');
               return $this->redirect(['article/index']);
           } else {
               //提示错误信息
               var_dump($model->getErrors());
               exit;
           }
       }
       return $this->render('add',['model'=>$model,'content'=>$content]);
    }
    //修改
    public function actionEdit($id){
        $model = Article::findOne(['id'=>$id]);
        $content = ArticleDetail::findOne(['article_id'=>$id]);
        $request = \Yii::$app->request;
        if ($request->isPost) {
            //都自动加载
            $model->load($request->post());
            $content->load($request->post());
            if ($model->validate() && $content->validate()) {
                $content->save();
                $model->create_time = time();
                $model->is_deleted = 0;
                $model->save();
                \Yii::$app->session->setFlash('success', '修改成功');
                return $this->redirect(['article/index']);
            } else {
                //提示错误信息
                var_dump($model->getErrors());
                exit;
            }
        }
        return $this->render('add',['model'=>$model,'content'=>$content]);
    }
    //删除
    public function actionDelete($id){
        $model = Article::findOne(['id'=>$id]);
        $model->is_deleted = 1;
        $model->save();
        \Yii::$app->session->setFlash('success', '删除成功');
        return $this->redirect(['article/index']);
    }
    //查看文件
    public function actionLook($id){
        $model = ArticleDetail::findOne(['article_id'=>$id]);
        return $this->render('look',['model'=>$model]);
    }
}