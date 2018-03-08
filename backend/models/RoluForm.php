<?php
namespace backend\models;


use backend\controllers\RbacController;
use yii\base\Model;

class RoluForm extends Model{
    public $name;  //角色名称
    public $description; //描述
    public $permission;//权限
    const SCENARIO_ADD ='add';
    const SCENARIO_EDIT ='EDIT';

    public function attributeLabels()
    {
        return [
            'name'=>'名称',
            'description'=>'描述',
            'permission'=>'权限'
        ];
    }

    public function rules()
    {
        return [
            [['name','description'],'required'],
            ['permission','safe'],
            [['name'],'check','on'=>self::SCENARIO_ADD],
            [['name'],'chage','on'=>self::SCENARIO_EDIT],
        ];
    }

    //多选框
    public static function getName(){
        $authManager =\Yii::$app->authManager;
        $permissions = $authManager->getPermissions();
        $a = [];
        foreach ($permissions as $permission ){
            $a[$permission->name]=$permission->description;
        }
        return $a;
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