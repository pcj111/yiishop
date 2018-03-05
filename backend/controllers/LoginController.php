<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/4 0004
 * Time: 12:41
 */

namespace backend\controllers;


use backend\models\Admin;
use backend\models\LoginForm;
use yii\captcha\CaptchaAction;
use yii\web\Controller;

class LoginController extends Controller
{
    public function actionLogin(){
        $model = new LoginForm();
        $request = \Yii::$app->request;
        if ($request->isPost){
            $model->load($request->post());
            if ($model->validate()){
              if ($model->login()){
                  $username ='欢迎大神'.\Yii::$app->user->identity->username.'回来';
                  \Yii::$app->session->setFlash('success',$username);
                  return $this->redirect(['admin/index']);
              }
            }

        }
        return $this->render('index',['model'=>$model]);
    }
    //退出
    public function actionExit(){
        \Yii::$app->user->logout();
        \Yii::$app->session->setFlash('success','退出成功');
        return $this->redirect(['login/login']);
    }
    //验证码
    public function actions()
    {
        return [
            'captcha'=>[
                'class'=>CaptchaAction::className(),
                'minLength'=>3,
                'maxLength'=>4
            ]
        ];
    }


}