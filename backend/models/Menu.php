<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id 上级菜单
 * @property string $path 路由
 * @property int $sort 排序
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'path'], 'required'],
            [['parent_id', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['path'], 'string', 'max' => 70],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent_id' => '上级菜单',
            'path' => '路由',
            'sort' => '排序',
        ];
    }

    //路由下拉框
    public static function getPath(){
       $authManger =  Yii::$app->authManager;
        $row = $authManger->getPermissions();
        return ArrayHelper::map($row,'name','name');
    }
    //parent
    public static function getName(){
       $menus = self::findAll(['parent_id'=>0]);
       $arr[]='顶级菜单';
       if($menus){
           foreach($menus as $menu){
               $arr[$menu->id] = $menu->name;
           }
       }
       return $arr;
    }
    public static function getMenus($menuItems){
        $menus = self::find()->where(['parent_id'=>0])->all();
        foreach ($menus as $menu){
            $items = [];
            $children = self::find()->where(['parent_id'=>$menu->id])->all();
            foreach ($children as $child){
                //只添加有权限的二级菜单
                if(Yii::$app->user->can($child->path))
                    $items[] = ['label' => $child->name, 'url' => [$child->path]];
            }
            if($items)
                $menuItems[] = ['label'=>$menu->name,'items'=>$items];
        }
        return $menuItems;
    }
    public function getM(){

    }
}
