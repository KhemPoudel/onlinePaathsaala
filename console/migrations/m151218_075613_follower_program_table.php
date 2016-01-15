<?php

use yii\db\Schema;
use yii\db\Migration;

class m151218_075613_follower_program_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%followerProgram}}', [
            'id' => Schema::TYPE_PK,
            'program_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        $this->addForeignKey('program_followed', 'followerProgram',
            'program_id', 'program', 'id','CASCADE','CASCADE');
        $this->addForeignKey('user_following', 'followerProgram',
            'user_id', 'user', 'id','CASCADE','CASCADE');

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
