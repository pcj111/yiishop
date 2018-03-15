<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m180314_064921_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'member_id'=>$this->integer()->notNull()->comment('用户id'),
            'name'=>$this->string(50)->notNull()->comment('收货人名称'),
            'province'=>$this->string(20)->notNull()->comment('省'),
            'city'=>$this->string(20)->notNull()->comment('市'),
            'area'=>$this->string(20)->notNull()->comment('县'),
            'address'=>$this->string(255)->notNull()->comment('详细地址'),
            'tel'=>$this->char(11)->notNull()->comment('电话号码'),
            'delivery_id'=>$this->integer()->notNull()->comment('配送方式id'),
            'delivery_name'=>$this->string()->notNull()->comment('配送方式名称'),
            'delivery_price'=>$this->float()->notNull()->comment('配送方式价格'),
            'payment_id'=>$this->integer()->notNull()->comment('支付方式id'),
            'payment_name'=>$this->string()->notNull()->comment('支付方式名称'),
            'total'=>$this->decimal()->notNull()->comment('订单金额'),
            'status'=>$this->integer()->notNull()->comment('订单状态'),
            'trade_no'=>$this->string()->comment('第三方支付交易号'),
            'create_time'=>$this->integer()->comment('创建时间')->notNull(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order');
    }
}
