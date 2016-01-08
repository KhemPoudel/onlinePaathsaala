<?php

use yii\db\Schema;
use yii\db\Migration;

class m151222_071839_follower_user_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%followerUsertoUser}}', [
            'id' => Schema::TYPE_PK,
            'follower_user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'followed_user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        $this->addForeignKey('user_follower', 'followerUsertoUser',
            'follower_user_id', 'user', 'id','CASCADE','CASCADE');
        $this->addForeignKey('user_followed', 'followerUsertoUser',
            'followed_user_id', 'user', 'id','CASCADE','CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%followerProgram}}');
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
