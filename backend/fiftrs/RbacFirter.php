<?php
namespace backend\fiftrs;

use yii\base\ActionFilter;
use yii\web\HttpException;

class RbacFirter extends ActionFilter{

    public function beforeAction($action)
    {


        //return \Yii::$app->user->can($action->uniqueId);

        //return true;//放行

        //return false;//拦截

       if( !\Yii::$app->user->can($action->uniqueId)){
          //如果用户没有等陆先登录
           if (\Yii::$app->user->isGuest){
              return $action->controller->redirect(\Yii::$app->user->loginUrl)->send();
           }

           throw new HttpException('403','你还没有这个访问权限');
       }
        return true;
    }
}