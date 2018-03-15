<?php

namespace frontend\controllers;

use app\models\Address;
use backend\models\Goods;
use backend\models\GoodsCategory;
use frontend\models\Member;
use frontend\models\LoginForm;
use frontend\aliyun\SignatureHelper;

class MemberController extends \yii\web\Controller
{
    //主页
    public function actionIndex(){
        $categorys = GoodsCategory::find()->where(['parent_id'=>0])->all();

        return $this->render('index',['categorys'=>$categorys]);
    }
    //注册
    public function actionRegist()
    {
        $model = new Member();
        $request = \Yii::$app->request;
        if ($request->isPost){
            $model->load($request->post(),'');
            if ($model->validate() && ($this->actionValidateSms($model->tel,$model->code)=='true')){
               //验证通过
                $model->password_hash = \Yii::$app->security->generatePasswordHash($model->password);
                $model->auth_key=\Yii::$app->security->generateRandomString();
                $model->created_at=time();
                $res = $model->save(0);
                return $this->redirect(['member/login']);
               // var_dump($model->getErrors());die;
            }else{
                var_dump($model->getErrors());
                return $this->redirect(['member/regist']);
            }
        }
        return $this->render('regist');
    }
    //异步验证用户名
    public function actionValidateUsername($username){
        if(Member::findOne(['username'=>$username])){
            return 'false';
        }
        return 'true';
    }
    //异步验证邮箱
    public function actionValidateEmail($email){
        if(Member::findOne(['email'=>$email])){
            return 'false';
        }
        return 'true';
    }
    //异步验证电话
    public function actionValidateTel($tel){
        if(Member::findOne(['tel'=>$tel])){
            return 'false';
        }
        return 'true';
    }
    //异步验证短信
    public function actionValidateSms($tel,$code){
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        $c = $redis->get('code_'.$tel);
        if ($c == $code){
            return 'true';
        }else{
            return 'false';
        }
    }
    //登录
    public function actionLogin(){
        $model = new LoginForm();
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $model->load($request->post(), '');
//            var_dump($model->login());die;
            if ($model->validate() && $model->login()) {
                return $this->redirect(['member/index']);
            }
        }
        return $this->render('login');
    }
    //注销
    public function actionLogout(){
        \Yii::$app->user->logout();
        return $this->redirect(['member/login']);
    }
    //address
    public function actionAddress(){

       $address = Address::findAll(['member_id'=>\Yii::$app->user->id]);
       $request = \Yii::$app->request;
       if ($request->isPost){
           $model = new Address();
           $model->load($request->post(),'');
           if ($model->validate()){
               $model->member_id=\Yii::$app->user->id;
               if($model->remember){
                   $model->default_status=1;
               }
               $model->save();
              return $this->redirect(['member/address']);
           }
       }
        return $this->render('address',['address'=>$address]);
    }
    //删除
    public function actionDelete($id){
       $model = Address::findOne(['id'=>$id]);
       $model->delete();
       return json_encode(['code'=>1]);
    }
    //修改
    public function actionEdit($id){
        $model = Address::findOne(['id'=>$id]);
        $request = \Yii::$app->request;
        if ($request->isPost){
            $model->load($request->post(),'');
            if ($model->validate()){
                if($model->remember){
                    $model->default_status=1;
                }
                $model->save();
                return $this->redirect(['member/address']);
            }
        }
        return $this->render('addressEdit',['model'=>$model]);
    }
    //短信验证
    public function actionSms($tel){
        $code = rand(100000,999999);
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        //保存到redis;
        $redis->set('code_'.$tel,$code,5*60);
      $r = \Yii::$app->sms->setTel($tel)->setParams(['code'=>$code])->send();
      //返回ajax
        if($r){
            return 'success';
        }else{
            return 'fail';
        }

    }
    //页面
    public function actionList($id){
        $lists = Goods::find()->where(['goods_category_id'=>$id])->all();
        return $this->render('list',['lists'=>$lists]);
    }
    //商品详情
    public function actionGoods($id){


         $good = Goods::findOne(['id'=>$id]);
         //var_dump($good);
        return $this->render('goods',['good'=>$good]);
    }


}
