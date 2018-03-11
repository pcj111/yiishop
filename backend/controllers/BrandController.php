<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/26 0026
 * Time: 17:31
 */

namespace backend\controllers;


use backend\fiftrs\RbacFirter;
use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\UploadedFile;

class BrandController extends Controller
{

    public $enableCsrfValidation = false;
   //页面
   public function actionIndex(){
       $a = Brand::find()->where(['is_deleted'=>0]);
     $paper = new Pagination();
     //总条数
     $paper->totalCount = Brand::find()->count();
     //显示多少条
       $paper->defaultPageSize = 5 ;
      $rows = $a->offset($paper->offset)->limit($paper->limit)->all();
     return $this->render('index',['rows'=>$rows,'paper'=>$paper]);
   }
   //添加
   public function actionAdd(){
       $model = new Brand();
       $request = \Yii::$app->request;
       if($request->isPost){
           //自动加载
           $model->load($request->post());
           if ($model->validate()){
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
            if ($model->validate()){
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
       \Yii::$app->db->createCommand()->update('brand',['is_deleted'=>1],['id'=>$id])->execute();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['brand/index']);
    }
    //图片上传
    public function actionUpload(){
        //var_dump($_FILES);die;
        //使用图片工具获取file对象
        $file = UploadedFile::getInstanceByName('file');
        //保存路径
        $path = '/upload/'.uniqid().$file->extension;
        $rs = $file->saveAs(\Yii::getAlias('@webroot').$path);
        if($rs){
            //上传成功
            return json_encode([
                'url'=>$path,
                'message'=>'success',
            ]);
        }
    }
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFirter::class,
                'except'=>['upload']

            ]
        ];
    }
}