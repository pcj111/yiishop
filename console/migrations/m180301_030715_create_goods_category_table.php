<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_category`.
 */
class m180301_030715_create_goods_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('goods_category', [
            'id' => $this->primaryKey(),
            'tree'=>$this->integer()->defaultValue(0),
            'lft'=>$this->integer(),
            'rgt'=>$this->integer(),
            'depth'=>$this->integer(),
            'name'=>$this->string(50)->comment('名称'),
            'parent_id'=>$this->integer()->comment('上级分类'),
            'intro'=>$this->text()->comment('简介')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('goods_category');
    }
}
