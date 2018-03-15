<?php

use yii\db\Migration;

/**
 * Handles the creation of table `payment`.
 */
class m180314_063535_create_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('payment', [
            'payment_id' => $this->primaryKey(),
            'payment_name'=>$this->string(50)->notNull()->comment('支付方式名称'),
            'total'=>$this->decimal()->comment('订单金额'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('payment');
    }
}
