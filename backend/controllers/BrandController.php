<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/26 0026
 * Time: 17:31
 */

namespace backend\controllers;


use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\UploadedFile;

class BrandController extends Controller
{
   //页面
   public function actionIndex(){
     $paper = new Pagination();
     //总条数
     $paper->totalCount = Brand::find()->count();
     //显示多少条
       $paper->defaultPageSize = 5 ;
      $rows = Brand::find()->offset($paper->offset)->limit($paper->limit)->all();
     return $this->render('index',['rows'=>$rows,'paper'=>$paper]);
   }
   //添加
   public function actionAdd(){
       $model = new Brand();
       $request = \Yii::$app->request;
       if($request->isPost){
           //自动加载
           $model->load($request->post());
           //通过验证
           $model->imgFile = UploadedFile::getInstance($model,'imgFile');
           if ($model->validate()){
               //处理图片
              $file = '/upload/'.uniqid().'.'.$model->imgFile->extension;
              $model->imgFile->saveAs(\Yii::getAlias('@webroot').$file,0);
              $model->logo = $file;
              //保存是否删除
               $model->is_deleted = 0;
               $model->save();
               \Yii::$app->session->setFlash('success','添加成功');
               return $this->redirect(['brand/index']);
           }else{
               //提示错误信息
               var_dump($model->getErrors());exit;
           }
       }
       return $this->render('add',['model'=>$model]);
   }
   //修改
    public function actionEdit($id){
       $model = Brand::findOne(['id'=>$id]);
        $request = \Yii::$app->request;
        if ($request->isPost){
            $model->load($request->post());
            $model->imgFile = UploadedFile::getInstance($model,'imgFile');
            if ($model->validate()){
                $file = '/upload/'.uniqid().'.'.$model->imgFile->extension;
                $model->imgFile->saveAs(\Yii::getAlias('@webroot').$file,0);
                $model->logo = $file;
                //保存是否删除
                $model->is_deleted = 0;
                $model->save();
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['brand/index']);
            }else{
                //提示错误信息
                var_dump($model->getErrors());exit;
            }

        }
        return $this->render('add',['model'=>$model]);
    }
    //删除
    public function actionDelete($id){
        $model = Brand::findOne(['id'=>$id]);
        
    }
}