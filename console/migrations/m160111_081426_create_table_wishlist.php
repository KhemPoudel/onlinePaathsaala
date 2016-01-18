<?php

use yii\db\Schema;
use yii\db\Migration;

class m160111_081426_create_table_wishlist extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%wishList}}', [
            'id' => Schema::TYPE_PK,
            'content' => Schema::TYPE_INTEGER . ' NOT NULL',
            'wishedBy' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        $this->addForeignKey('wishedBy', 'wishList',
            'wishedBy', 'user', 'id','CASCADE','CASCADE');
        $this->addForeignKey('content', 'wishList',
            'content', 'content', 'id','CASCADE','CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%wishList}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
