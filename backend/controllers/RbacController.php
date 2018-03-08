<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/7 0007
 * Time: 14:17
 */

namespace backend\controllers;


use backend\models\PremissionForm;
use yii\web\Controller;
use yii\web\HttpException;

class RbacController extends Controller
{
    //权限
    public function actionTest(){
        //1.添加权限
        //实例化对象
       $authManager = \Yii::$app->authManager;
        //添加品牌
       /*$permission =  $authManager->createPermission('brand/add');
       $permission->description='添加品牌';
        $authManager->add($permission);
       $permission1 = $authManager->createPermission('brand/index');
       $permission1->description='品牌列表';
        $authManager->add($permission1);*/
       //添加角色
      /* $role =  $authManager->createRole('管理员');
       $role1 =$authManager->createRole('普通用户');
       $authManager->add($role);
       $authManager->add($role1);*/
       //分配权限
        //普通用户只能进查看列表
       /* $a = $authManager->getRole('普通用户');
        $b = $authManager->getPermission('brand/index');
        $g = $authManager->getRole('管理员');
        $d = $authManager->getPermission('brand/add');
        $authManager->addChild($a,$b);
        $authManager->addChild($g,$b);
        $authManager->addChild($g,$d);*/

        $a = $authManager->getRole('普通用户');
        $g = $authManager->getRole('管理员');
        $authManager->assign($g,2);
        $authManager->assign($a,1);

        //管理员  添加和列表都可以进
        echo'操作成功';
    }
    //添加路由
    public function actionAdd(){
        $model = new PremissionForm();
        $model->scenario = PremissionForm::SCENARIO_ADD;
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                //实例化
               $authManager =  \Yii::$app->authManager;
               $rolu=$authManager->createPermission($model->name);
                $rolu->description = $model->description;
                $authManager->add($rolu);
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['rbac/index']);
            }
        }

        return $this->render('add',['model'=>$model]);
    }

    //显示
    public function actionIndex(){
        //获取
        $authManagers = \Yii::$app->authManager;
       // var_dump($authManagers);die;
      return $this->render('index',['authManagers'=>$authManagers->getPermissions()]);
    }
    //修改
    public function actionEdit($name){
        //实例化一个
        $authManager =  \Yii::$app->authManager;
        //获取权限
        $premission = $authManager->getPermission($name);
        //判断是否重名
        if($premission==null){
            throw new HttpException('404','权限不存在');
        }
        //实例化对象
        $model = new PremissionForm();
        //edit的应用场景
        $model->scenario = PremissionForm::SCENARIO_EDIT;
        //保存数据到model上
        $model->name = $premission->name;
        $model->description = $premission->description;
         $request = \Yii::$app->request;
         if ($request->isPost){
             $model->load($request->post());
             if ($model->validate()){
                 $premission->name = $model->name;
                 $premission->description = $model->description;
                 //更新方法
                 $authManager->update($name,$premission);
                 \Yii::$app->session->setFlash('success','修改成功');
                 return $this->redirect(['rbac/index']);
             }
         }
       return $this->render('add',['model'=>$model]);
    }
    public function actionDelete($name){
        $authManager =  \Yii::$app->authManager;
        $premission = $authManager->getPermission($name);
        $authManager->remove($premission);
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['rbac/index']);
    }
}