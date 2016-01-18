<?php

use yii\db\Schema;
use yii\db\Migration;

class m160112_184259_create_table_for_likes_and_followers_count_for_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%countTable}}', [
            'id' => Schema::TYPE_PK,
            'noOfLikes' => Schema::TYPE_INTEGER . ' NOT NULL',
            'noOfDislikes' => Schema::TYPE_INTEGER . ' NOT NULL',
            'noOfFollowers' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user'=>Schema::TYPE_INTEGER. ' NOT NULL',
        ], $tableOptions);
        $this->addForeignKey('user', 'countTable',
            'user', 'user', 'id','CASCADE','CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%countTable}}');
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
