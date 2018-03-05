<?php
namespace backend\controllers;


use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsIntro;
use backend\models\SeachForm;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\UploadedFile;

class GoodsController extends Controller{

    public $enableCsrfValidation = false;
    //展示列表
    public function actionIndex(){

        //分页插件
        $query = Goods::find()->where(['status'=>1]);
        //搜索
        $request = \Yii::$app->request;
        $name = $request->get('name');
        $sn = $request->get('sn');
        $start = $request->get('start');
        $end = $request->get('end');
        if ($name){
            $query->andWhere(['like','name',$name]);
        }
        if ($sn){
            $query->andWhere(['like','sn',$sn]);
        }
        if ($start){
            $query->andWhere(['>','market_price',$start]);
        }
        if ($end){
            $query->andWhere(['<','shop_price',$end]);
        }

        $paper = new Pagination();
        $paper->totalCount = Goods::find()->count();
        $paper->defaultPageSize = 5;

        $rows = $query->offset($paper->offset)->limit($paper->limit)->all();
        return $this->render('index',['rows'=>$rows,'paper'=>$paper,]);
    }
    //添加
    public function actionAdd(){
        $model = new Goods();
        $intro = new GoodsIntro();
        $request = \Yii::$app->request;
        if ($request->isPost){
            $model->load($request->post());
            //内容
            $intro->load($request->post());
            //var_dump($request->post());die;
            if ($model->validate() && $intro->validate()){
                //保存时间
                $model->create_time = time();
                $model->view_times=0;
                //保存状态
                $model->status = 1 ;
                $model->sn= $model->addSn();
                //var_dump($intro->content);die;
                //$goods = Goods::find()->all();
               // echo'<pre>';
                //var_dump($goods['id']);die;
                //$intro->goods_id = $goods->id;
                $intro->save();
                $model->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['goods/index']);
            }else{
                var_dump($model->getErrors());die;
            }
        }
        $nodes =GoodsCategory::find()->select(['id','parent_id','name'])->asArray()->all();
        $nodes[] = ['id'=>0,'parent_id'=>0,'name'=>'顶层分类'];
       //var_dump($model->getErrors());die;
        return $this->render('add',['model'=>$model,'intro'=>$intro,'nodes'=>json_encode($nodes)]);
    }
    //删除
     public function actionEdit($id){
         $model = Goods::findOne(['id'=>$id]);
         $intro = GoodsIntro::findOne(['goods_id'=>$id]);
         $request = \Yii::$app->request;
         if ($request->isPost){
             $model->load($request->post());
             //内容
             $intro->load($request->post());
             //var_dump($request->post());die;
             if ($model->validate() && $intro->validate()){
                 //保存时间
                 $model->create_time = time();
                 $model->view_times=0;//保存状态
                 $model->status = 1 ;
                 $intro->save();
                 $model->save();
                 \Yii::$app->session->setFlash('success','修改成功');
                 return $this->redirect(['goods/index']);
             }else{
                 var_dump($model->getErrors());die;
             }
         }
         $nodes =GoodsCategory::find()->select(['id','parent_id','name'])->asArray()->all();
         $nodes[] = ['id'=>0,'parent_id'=>0,'name'=>'顶层分类'];
        return $this->render('add',['model'=>$model,'intro'=>$intro,'nodes'=>json_encode($nodes)]);
     }
     //删除
    public function actionDelete($id){
        $model = Goods::findOne(['id'=>$id]);
        $model->status = 0;
        $model->save();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['goods/index']);
    }

    //查看内容
    public function actionLook($id){
        //echo'11';die;
        $model = GoodsIntro::findOne(['goods_id'=>$id]);
        return $this->render('intro',['model'=>$model]);
    }


    //图片上传
    public function actionImg(){
        $file = UploadedFile::getInstanceByName('file');
        //保存路径
        $path = '/upload/'.uniqid().$file->extension;
        $rs = $file->saveAs(\Yii::getAlias('@webroot').$path);
        if ($rs){
            return json_encode([
                'url'=>$path,
                'message'=>'success',
            ]);
        }
    }
    //付文本编辑
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config'=> [
                    "imageUrlPrefix"  => "http://admin.yiishop.com",//图片访问路径前缀
                    "imagePathFormat" => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageRoot" => \Yii::getAlias("@webroot"),
                ],
            ]
        ];
    }

}