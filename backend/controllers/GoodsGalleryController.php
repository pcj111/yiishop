<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/3 0003
 * Time: 10:58
 */

namespace backend\controllers;


use backend\models\GoodsGallery;
use yii\web\Controller;
use yii\web\UploadedFile;

class GoodsGalleryController extends Controller
{
    //关闭验证
    public $enableCsrfValidation = false;

    //图片显示
   public function actionIndex($id){

       $imgs = GoodsGallery::find()->where(['goods_id'=>$id])->all();

       return $this->render('index',['imgs'=>$imgs,'id'=>$id]);

   }

       //图片上传
       public function actionImg(){
           $file = UploadedFile::getInstanceByName('file');
           //保存路径
           $path = '/upload/'.uniqid().'.'.$file->extension;
           $rs = $file->saveAs(\Yii::getAlias('@webroot').$path);
           if ($rs){
               return json_encode([
                   'url'=>$path,
                   'message'=>'success',
               ]);
           }
       }
       //添加
       public function actionAdd(){
           $request = \Yii::$app->request;
           if ($request->isPost){
               $good = new GoodsGallery();
               //保存属性
               $good->path = $request->post('path');
               $good->goods_id = $request->post('goods_id');
               //保存
               $good->save();
               //返回json格式的数据
               return json_encode(['path'=>$good->path,'good_id'=>$good->id,'code'=>1]);
           }
       }
       public function actionDelete($id){
           $model = GoodsGallery::findOne(['id'=>$id]);
           $model->delete();
           \Yii::$app->session->setFlash('success','删除成功');
           return $this->redirect(['goods-gallery/index','id'=>$model->id]);
       }

}