<?php

use yii\db\Migration;

/**
 * Handles the creation of table `brand`.
 */
class m180226_091756_create_brand_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->comment('名称'),
            'intro' => $this->text()->comment('简介'),
            'logo' => $this->string()->notNull()->comment('logo图片'),
            'sort' => $this->integer(11)->comment('排序'),
            'is_deleted' =>$this->integer(1)->defaultValue(0)->comment('状态0正常1删除')

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('brand');
    }
}
