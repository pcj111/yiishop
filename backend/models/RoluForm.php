<?php
namespace backend\models;


use backend\controllers\RbacController;
use yii\base\Model;

class RoluForm extends Model{
    public $name;  //角色名称
    public $description; //描述
    public $permission;//权限

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
}