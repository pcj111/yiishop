<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/4 0004
 * Time: 10:58
 */

namespace backend\controllers;


use backend\fiftrs\RbacFirter;
use backend\models\Admin;
use Symfony\Component\DomCrawler\Field\InputFormField;
use yii\data\Pagination;
use yii\web\Controller;

class AdminController extends Controller
{
    //public $enableCsrfValidation=false;
    //视图
    public function actionIndex(){
       // \Yii::$app->user->username;
        $query = Admin::find();
        $paper = new Pagination();
        $paper->totalCount=Admin::find()->count();
        $paper->defaultPageSize = 5;
        $rows = $query->offset($paper->offset)->limit($paper->limit)->all();
        return $this->render('index',['rows'=>$rows,'paper'=>$paper]);
    }
    //添加
    public function actionAdd(){
        $model = new Admin();
        $request = \Yii::$app->request;
        if ($request->isPost){
            $model->load($request->post());
            if ($model->validate()){
                $model->password_hash = \Yii::$app->security->generatePasswordHash($model->password_hash);
                $model->status = 1;
                $model->auth_key=\Yii::$app->security->generateRandomString();
                //创建时间
                $model->created_at=time();
                if ( $model->save()){
                    $authManager = \Yii::$app->authManager;
                    foreach ($model->roles as $role){
                        $a = $authManager->getRole($role);
                        $authManager->assign($a,$model->id);
                    }
                }
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['admin/index']);
            } else {
                //提示错误信息
                var_dump($model->getErrors());
                exit;
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    //修改
    public function actionEdit($id)
    {
        $model = Admin::findOne(['id' => $id]);
        $authManger = \Yii::$app->authManager;
        $rolus =  $authManger->getRolesByUser($id);
        $model->roles = [];
        foreach ($rolus as $role){
          $model->roles[]=$role->name;
        }
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
                $model->new_password = \Yii::$app->security->generatePasswordHash($model->new_password);
                $model->updated_at =time();
                if ($model->save()){
                    //提交多选框
                    //清楚该角色的所有权限
                    $authManger->revokeAll($model->id);
                    if (is_array($model->roles)){
                        foreach ($model->roles as $permissionName){
                            $permission = $authManger->getRole($permissionName);
                            $authManger->assign($permission,$model->id);
                        }
                    }
                }
                \Yii::$app->session->setFlash('success', '修改成功');
                return $this->redirect(['admin/index']);
            } else {
                //提示错误信息
                var_dump($model->getErrors());
                exit;
            }
        }
            return $this->render('edit', ['model' => $model]);
    }
    //删除
    public function actionDelete($id){
        $model = Admin::findOne(['id'=>$id]);
        $model->delete();
        return json_encode(['code'=>1]);
    }
    //修改密码
    public function actionRs()
    {
        $id = \Yii::$app->user->id;
        $model = Admin::findOne(['id' => $id]);
        $model->scenario = Admin::SCENARIO_EDIT;
        $request = \Yii::$app->request;
        //var_dump($request->post());
        if ($request->isPost) {
            //var_dump($admin);die;
            $model->load($request->post());
            //如果成功
            if ($model->validate()) {
                $check = \Yii::$app->security->validatePassword($model->old_password, $model->password_hash);
                if ($check) {
                    //判断新密码和重置密码相等 然后hash保存
                    if ($model->new_password === $model->password) {
                        $model->password_hash = \Yii::$app->security->generatePasswordHash($model->new_password);
                        $model->save();
                        \Yii::$app->session->setFlash('success', '修改成功');
                        return $this->redirect(['admin/index']);
                    }
                } else {
                    \Yii::$app->session->setFlash('success', '密码不正确');
                    return $this->redirect(['admin/rs']);
                }
            }
        }
        return $this->render('password', ['model' => $model]);
     }
     //重置密码
    public function actionRes($id){
        $model = Admin::findOne(['id'=>$id]);
        $model->password_hash='';
        $request =\Yii::$app->request;
        if ($request->isPost){
            $model->load($request->post());
            if ($model->validate()){
                $model->password_hash = \Yii::$app->security->generatePasswordHash($model->password_hash);
                $model->save();
                \Yii::$app->session->setFlash('success', '设置成功');
                return $this->redirect(['admin/index']);
            }
        }

        return $this->render('res',['model'=>$model]);
    }
    //Rbac验证(权限)
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFirter::class,
                'except'=>['login','logout','rs','captcha']
            ]
        ];
    }
 }