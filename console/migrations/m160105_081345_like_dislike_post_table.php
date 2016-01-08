<?php

use yii\db\Schema;
use yii\db\Migration;

class m160105_081345_like_dislike_post_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%likeDislikeContent}}', [
            'id' => Schema::TYPE_PK,
            'likeOrDislike' => Schema::TYPE_INTEGER . ' NOT NULL',
            'likedOrDislikedBy' => Schema::TYPE_INTEGER . ' NOT NULL',
            'content' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        $this->addForeignKey('likedOrDislikedBy', 'likeDislikeContent',
            'likedOrDislikedBy', 'user', 'id','CASCADE','CASCADE');
        $this->addForeignKey('likedOrDislikedContent', 'likeDislikeContent',
            'content', 'content', 'id','CASCADE','CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%likeDislikeContent}}');
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
