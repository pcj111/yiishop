<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m180308_060706_create_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'parent_id'=>$this->integer()->notNull()->comment('上级菜单'),
            'path'=>$this->string(70)->notNull()->comment('路由'),
            'sort'=>$this->integer()->comment('排序'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('menu');
    }
}
