<?php
namespace backend\models;

use yii\base\Model;

class PremissionForm extends Model {

    public $name;//权限名称
    public $description;//描述

    const SCENARIO_ADD ='add';
    const SCENARIO_EDIT ='EDIT';

    public function attributeLabels()
    {
        return [
            'name'=>'权限名称',
            'description'=>'描述',
        ];
    }

    public function rules()
    {
        return [
            [['name','description'],'required'],
            [['name'],'check','on'=>self::SCENARIO_ADD],
            [['name'],'chage','on'=>self::SCENARIO_EDIT],
        ];
    }

    //设定check的方法
    public function check(){
        $authManger = \Yii::$app->authManager;
        if($authManger->getPermission($this->name)){
           return $this->addError('name','路由已存在');
        }
    }

    public function chage(){
        if (\Yii::$app->request->get('name') !=$this->name){
           $this->check();
        }
    }

}