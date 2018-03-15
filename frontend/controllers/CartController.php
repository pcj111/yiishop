<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/12 0012
 * Time: 16:03
 */

namespace frontend\controllers;


use app\models\Address;
use app\models\Cart;
use app\models\Delivery;
use app\models\Order;
use app\models\OrderGoods;
use app\models\Payment;
use backend\models\Goods;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use yii\web\Controller;
use yii\web\Cookie;

class CartController extends Controller
{
    //成功加入购物车
    public function actionCuss($goods_id,$amount){

        if (\Yii::$app->user->isGuest){
            //设计
            //$carts = [1=>3,2=>7]
            //是游客,判断cookies有没有购物车记录
            $cookies = \Yii::$app->request->cookies;
            $val = $cookies->getValue('carts');
            //如果cookies有值 将值序列化
            if ($val){
                $carts = unserialize($val);
            }else{
                $carts=[];
            }
            //如果购物车有记录就把商品数量累计上去
            if (array_key_exists($goods_id,$carts)){
                //把数量累计上面去
                $carts[$goods_id] +=$amount;
            }else{
                $carts[$goods_id] = $amount;
            }
            //保存cookies
            $cookie = new Cookie();
            $cookie->name = 'carts';
            $cookie->value = serialize($carts);
            $cookie->expire = 7*24*3600;
            $cookies = \Yii::$app->response->cookies;
            $cookies->add($cookie);

        }else{
            //不是游客,保存到数据库上面
            //首先判断检查商品是否在数据库中是,如果有 更新
            $old = Cart::findOne(['goods_id'=>$goods_id]);
            if ($old){
                $old->amount = $amount;
                $old->save();
            }else{
                $model = new Cart();
                $request = \Yii::$app->request;
                //检查是否是get提交
                    $model->load($request->get(),'');
                    $model->member_id = \Yii::$app->user->id;
                    if ($model->validate()){
                        $model->save();
                    }else{
                        var_dump($model->getErrors());die;
                    }

            }
        }
        return $this->render('success');
    }
    //结算列表
    public function actionInfo(){
        if (\Yii::$app->user->isGuest){
            //是游客
            $cookie = \Yii::$app->request->cookies;
            $value  = $cookie->getValue('carts');
            if ($value){
                $carts = serialize($value);
            }else{
                $carts=[];
            }

        }else{
            //不是游客
            $carts = Cart::find()->where(['member_id'=>\Yii::$app->user->id])->all();
        }
        return $this->render('info',['carts'=>$carts]);
    }
    //ajax删除
    public function actionAjaxCart($goods_id,$amount){
        if (\Yii::$app->user->isGuest){
            //设计
            //$carts = [1=>3,2=>7]
            //是游客,判断cookies有没有购物车记录
            $cookies = \Yii::$app->request->cookies;
            $val = $cookies->getValue('carts');
            //如果cookies有值 将值序列化
            if ($val){
                $carts = unserialize($val);
            }else{
                $carts=[];
            }
            //如果购物车有记录就把商品数量累计上去
            if ($amount){
                //把数量累计上面去
                $carts[$goods_id] =$amount;
            }else{
                unset($carts[$goods_id]);
            }
            $cookie = new Cookie();
            $cookie->name = 'carts';
           $cookie->value = serialize($carts);
            $cookie->expire = 7*24*3600;
           $cookies = \Yii::$app->response->cookies;
          $cookies->add($cookie);

        }else{

            //首先判断检查商品是否在数据库中是,如果有 更新
            $old = Cart::findOne(['goods_id'=>$goods_id]);
            if ($amount){
                $old->amount = $amount;
                $old->save();
            }else{
                $old->delete();


            }
        }
    }
    //结算页面显示
    public function actionIndex(){
        if(\Yii::$app->user->isGuest){
            //是游客 先登录
            return $this->redirect(['member/login']);
        }else{
            //收货地址
            $res =  Address::find()->where(['member_id'=>\Yii::$app->user->id])->all();
            //购物车信息
            $rows = Cart::find()->where(['member_id'=>\Yii::$app->user->id])->all();
            $deliverys = Delivery::find()->all();
            $payments = Payment::find()->all();


            return $this->render('index',['res'=>$res,'rows'=>$rows,'deliverys'=>$deliverys,'payments'=>$payments]);
        }


    }
        public function actionSubmitOrder(){
            $request = \Yii::$app->request;
            if ($request->isPost){
                //查出地址
                $order = new Order();
                $address = Address::findOne(['id'=>$request->post('address_id')]);
                //var_dump($request->post());die;
                $order->member_id = \Yii::$app->user->id;
                $order->name = $address->name;
                $order->province = $address->province;
                $order->city = $address->city;
                $order->area = $address->area;
                $order->address = $address->address;
                $order->tel = $address->phone;
                $delivery = Delivery::findOne(['delivery_id'=>$request->post('delivery')]);
                //var_dump($delivery);die;
                $order->delivery_id = $request->post('delivery');
                $order->delivery_name = $delivery->delivery_name;
                $order->delivery_price= $delivery->delivery_price;
                $payment = Payment::findOne(['payment_id'=>$request->post('pay')]);
                //var_dump($payment);die;
                $order->payment_id = $request->post('pay');
                $order->payment_name = $payment->payment_name;
                $order->total = 0;
                $order->status = 2;
                $order->trade_no = \Yii::$app->security->generateRandomString();
                $order->create_time = time();
                //开启事物
                $transaction =\Yii::$app->db->beginTransaction();
                try{
                    $order->save();
                    //保存订单.循环购物车
                    $carts = Cart::find()->where(['member_id'=>\Yii::$app->user->id])->all();
                    foreach ($carts as $cart){
                        $goods  = Goods::findOne(['id'=>$cart->goods_id]);
                        //判断库存数量,小于订购数量 跑出异常
                        if ($goods->stock <$cart->amount){
                            throw new Exception('商品['.$goods->name.']库存不足');
                        }
                        //减扣商品库存
                        $goods->stock-=$cart->amount;
                        $goods->save();
                        //
                        $orderGoods = new OrderGoods();
                        $orderGoods->order_id = $order->id;
                        $orderGoods->good_id = $goods->id;
                        $orderGoods->good_name = $goods->name;
                        $orderGoods->logo = $goods->logo;
                        $orderGoods->price =$goods->shop_price;
                        $orderGoods->amount = $cart->amount;
                        $orderGoods->total = $orderGoods->price* $orderGoods->amount;
                        $orderGoods->save();
                        //
                        $order->total += $order->delivery_price;
                    }
                    $order->save();
                    Cart::deleteAll(['member_id'=>\Yii::$app->user->id]);
                    $transaction->commit();
                    //提交成功后显示页面
                    return $this->render('flow3');
                }catch(Exception $e){
                    $transaction->rollBack();
                };

            }
        }


}