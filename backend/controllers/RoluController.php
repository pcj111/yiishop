<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/7 0007
 * Time: 23:45
 */

namespace backend\controllers;


use backend\models\RoluForm;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use yii\web\Controller;
use yii\web\HttpException;

class RoluController extends Controller
{
   //显示
    public function actionIndex(){
      $authManagers = \Yii::$app->authManager;
        return $this->render('index',['authManagers'=>$authManagers->getRoles()]);
    }
    //添加
    public function actionAdd(){
        $model = new RoluForm();
        $request = \Yii::$app->request;
        if ($request->isPost){
            $model->load($request->post());
            if ($model->validate()){
               // var_dump($model->permission);die;
                $authManager = \Yii::$app->authManager;
                $role = $authManager->createRole($model->name);
                $role->description = $model->description;
                if ($authManager->add($role)){
                    $permissions = $model->permission;
                    foreach ($permissions as $permission){
                        $a = $authManager->getPermission($permission);
                        $authManager->addChild($role,$a);
                    }
                    \Yii::$app->session->setFlash('success','添加权限成功');
                    return $this->redirect(['rolu/index']);
                }else{
                    \Yii::$app->session->setFlash('success','添加权限失败,请重新添加');
                    return $this->redirect(['rolu/add']);
                }
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    //删除
    public function actionDelete($name){
        $authManager =  \Yii::$app->authManager;
        $a = $authManager->getRole($name);
        $authManager->remove($a);
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['rolu/index']);
    }
    //修改
    public function actionEdit($name){
        $authManager = \Yii::$app->authManager;
        $a =  $authManager->getRole($name);
        if ($a==null){
            throw new HttpException('403','角色不存在');
        }
        $model = new RoluForm();
        $model->name = $a->name;
        $model->description = $a->description;
        $permissions = $authManager->getPermissionsByRole($a->name);
        foreach($permissions as $permission){
            $arr[] = $permission->name;
        }
        $model->permission =$arr;
        $request = \Yii::$app->request;
        if ($request->isPost){
            $model->load($request->post());
            if ($model->validate()){
                $a->name = $model->name;
                $a->description=$model->validate();
                $authManager->update($name,$a);
                //提交多选框

                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['rolu/index']);
            }
        }

        return $this->render('add',['model'=>$model]);
    }
}