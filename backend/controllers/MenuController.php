<?php

namespace backend\controllers;

use backend\models\Menu;

class MenuController extends \yii\web\Controller
{
    public $enableCsrfValidation=false;
    //显示列表
    public function actionIndex()
    {
        $rows = Menu::find()->all();
        return $this->render('index',['rows'=>$rows]);
    }
    //添加
    public function actionAdd(){
       $model = new Menu();
       $request = \Yii::$app->request;
       if ($request->isPost) {
           $model->load($request->post());
           if ($model->validate()) {
               $model->save();
               \Yii::$app->session->setFlash('success', '添加成功');
               return $this->redirect(['menu/index']);
           } else {
               //提示错误信息
               var_dump($model->getErrors());
               exit;
           }
       }  return $this->render('add',['model'=>$model]);
    }
    //删除
    public function actionDelete($id){
        $model = Menu::findOne(['id'=>$id]);
        $model->delete();
        return json_encode(['code'=>1]);
    }
    //修改
    public function actionEdit($id){
        $model = Menu::findOne(['id'=>$id]);
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
                $model->save();
                \Yii::$app->session->setFlash('success', '修改成功');
                return $this->redirect(['menu/index']);
            } else {
                //提示错误信息
                var_dump($model->getErrors());
                exit;
            }
        }
          return $this->render('add',['model'=>$model]);
    }

}
