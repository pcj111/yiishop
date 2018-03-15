<?php

use yii\db\Migration;

/**
 * Handles the creation of table `delivery`.
 */
class m180314_063001_create_delivery_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('delivery', [
            'delivery_id' => $this->primaryKey(),
            'delivery_name'=>$this->string(50)->notNull()->comment('配送方式名称'),
            'delivery_price'=>$this->decimal()->comment('配送方式价格'),



        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('delivery');
    }
}
