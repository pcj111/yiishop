<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member`.
 */
class m180309_032341_create_member_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
            'username' => $this->string(50)->comment('用户名'),
            'auth_key' => $this->string(32),
            'password_hash' => $this->string(100)->comment('密码'),
            'email' => $this->string(100)->comment('邮箱'),
            'tel' => $this->string(11)->comment('电话'),
            'last_login_time' => $this->integer()->comment('最后登录时间'),
            'last_login_ip' =>$this->integer()->comment('最后登录ip'),
            'status' => $this->integer(1)->comment('状态1正常0删除'),
            'created_at' => $this->integer()->comment('添加时间'),
            'updated_at' => $this->integer()->comment('修改时间')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('member');
    }
}
