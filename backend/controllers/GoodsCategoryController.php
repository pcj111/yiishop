<?php

namespace backend\controllers;

use backend\models\GoodsCategory;
use yii\data\Pagination;

class GoodsCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $paper = new Pagination();
        $paper->totalCount=GoodsCategory::find()->count();
        $paper->defaultPageSize=5;
        $rows = GoodsCategory::find()->offset($paper->offset)->limit($paper->limit)->all();
        return $this->render('index',['rows'=>$rows,'paper'=>$paper]);
    }
    //添加
    public function actionAdd(){
       $model = new GoodsCategory();
       $request = \Yii::$app->request;
       if($request->isPost){
           $model->load($request->post());
           if ($model->validate()){
               //两种情况,当parent_id=0或不等于0
               if ($model->parent_id){
                   //子分类
                   $parent = GoodsCategory::findOne(['id'=>$model->parent_id]) ;
                   $model->prependTo($parent);
               }else{
                   //父分类
                   $model->makeRoot();
               }
           }
           \Yii::$app->session->setFlash('success','添加成功');
           return $this->redirect(['goods-category/index']);
       }
       //分类ztree
        $nodes = GoodsCategory::find()->select(['id','parent_id','name'])->asArray()->all();
        $nodes[] = ['id'=>0,'parent_id'=>0,'name'=>'顶层分类'];

       return $this->render('add',['model'=>$model,'nodes'=>json_encode($nodes)]);
    }
    //修改
    public function actionEdit($id){

        $model = GoodsCategory::findOne(['id'=>$id]);
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if ($model->validate()){
                //两种情况,当parent_id=0或不等于0
                if ($model->parent_id){
                    //子分类
                    $parent = GoodsCategory::findOne(['id'=>$model->parent_id]) ;
                    $model->prependTo($parent);
                }else{
                    //父分类
                    $model->makeRoot();
                }
            }
            \Yii::$app->session->setFlash('success','修改成功');
            return $this->redirect(['goods-category/index']);
        }
        $nodes = GoodsCategory::find()->select(['id','parent_id','name'])->asArray()->all();
        $nodes[] = ['id'=>0,'parent_id'=>0,'name'=>'顶层分类'];

        return $this->render('add',['model'=>$model,'nodes'=>json_encode($nodes)]);
    }
    //删除
    public function actionDelete($id){
        $model = GoodsCategory::findOne(['id'=>$id]);
        if($model->parent_id){
            $model->delete();
            \Yii::$app->session->setFlash('success','删除成功');
        }else{
            \Yii::$app->session->setFlash('danger','父级不能删除');
        }
        return $this->redirect(['goods-category/index']);
    }
    //测试嵌套集合
    public function actionText(){
        /*$countries = new GoodsCategory();
        $countries->name = '电视机';
        $countries->parent_id='1';
        $countries->makeRoot();*/

        /*$russia = new GoodsCategory();
        $russia->name='曲屏';
        $prant = GoodsCategory::findOne(['id'=>2]);
        //var_dump($prant);die;
        $russia->parent_id=$prant->id;
        $russia->prependTo($prant);
        echo'成功';*/
    }


}
