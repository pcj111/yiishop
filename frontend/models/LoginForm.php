<?php
namespace frontend\models;

use frontend\models\Member;
use yii\base\Model;

class LoginForm extends Model{
    public $username;//用户名
    public $password;//密码
    public $remember;//记住我
    public $captcha;//验证码

    public function rules()
    {
        return [
            [['username','password'],'required'],
            [['remember'],'safe'],
            ['captcha','captcha','captchaAction'=>'site/captcha']
        ];
    }

    public function login(){
        $member = Member::findOne(['username'=>$this->username]);
        //有用户名验证密码
//        var_dump(\Yii::$app->security->validatePassword($this->password,$member->password_hash));die;
        if ($member && \Yii::$app->security->validatePassword($this->password,$member->password_hash)){

            $member->last_login_time =time();
            $member->last_login_ip = ip2long($_SERVER["REMOTE_ADDR"]);
            $member->save(0);
            return \Yii::$app->user->login($member,$this->remember?7*24*3600:0);
        }
        return false;
    }
}