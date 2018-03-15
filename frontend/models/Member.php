<?php

namespace frontend\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "member".
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $auth_key
 * @property string $password_hash 密码
 * @property string $email 邮箱
 * @property string $tel 电话
 * @property int $last_login_time 最后登录时间
 * @property int $last_login_ip 最后登录ip
 * @property int $status 状态1正常0删除
 * @property int $created_at 添加时间
 * @property int $updated_at 修改时间
 */
class Member extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public $password; //确认密码
    public $captcha;//验证码
    public $code;//短信验证

    public static function tableName()
    {
        return 'member';

    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password'],'required'],
            [['last_login_time', 'last_login_ip', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'email'], 'string', 'max' => 100],
            [['tel'], 'string', 'max' => 11],
            ['captcha','captcha','captchaAction'=>'site/captcha'],
            [['code'],'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => 'Auth Key',
            'password_hash' => '密码',
            'email' => '邮箱',
            'tel' => '电话',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录ip',
            'status' => '状态1正常0删除',
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
        ];
    }

    public static function findIdentity($id)
    {
       return self::findOne(['id'=>$id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey()===$authKey;
    }
}
