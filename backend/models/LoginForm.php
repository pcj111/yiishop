<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/4 0004
 * Time: 12:39
 */

namespace backend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $code;
    public $member;


    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码',
            'code'=>'验证码',
            'member'=>'记住我'
        ];
    }

    public function rules()
    {
        return [
            [['username','password'],'required'],
            [['member'],'safe'],
            ['code','captcha','captchaAction'=>'login/captcha']
        ];
    }

   public function login(){
       $admin = Admin::findOne(['username'=>$this->username]);
       //用户名验证成功  验证密码
       if ($admin){
           //验证密码
           $password = \Yii::$app->security->validatePassword($this->password,$admin->password_hash);
           //密码成功,保存session
           if ($password){
               $admin->last_login_time =time();
               $admin->last_login_ip = ip2long($_SERVER["REMOTE_ADDR"]);
               $admin->save();
               //判断用户有没有勾选member,勾选了保存
               return \Yii::$app->user->login($admin,$this->member?3600*12:0);
           }else{
               $this->addError('password','用户名密码不正确');
           }
       }else{
           $this->addError('username','用户名密码不正确');
       }
       return false;
   }
}