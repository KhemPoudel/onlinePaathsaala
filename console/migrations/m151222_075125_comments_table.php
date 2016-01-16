<?php

use yii\db\Schema;
use yii\db\Migration;

class m151222_075125_comments_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%commentsContent}}', [
            'id' => Schema::TYPE_PK,
            'comment' => Schema::TYPE_STRING . ' NOT NULL',
            'commentedBy' => Schema::TYPE_INTEGER . ' NOT NULL',
            'commentedOn' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        $this->addForeignKey('commented_by', 'commentsContent',
            'commentedBy', 'user', 'id','CASCADE','CASCADE');
        $this->addForeignKey('commented_on', 'commentsContent',
            'commentedOn', 'content', 'id','CASCADE','CASCADE');
    }

    public function down()
    {
        $this->dropTable('commentsContent');
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
