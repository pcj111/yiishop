<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_intro`.
 */
class m180302_023300_create_goods_intro_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('goods_intro', [
            'goods_id' => $this->primaryKey(),
            'content'=>$this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('goods_intro');
    }
}
