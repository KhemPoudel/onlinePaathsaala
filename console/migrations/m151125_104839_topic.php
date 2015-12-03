<?php

use yii\db\Schema;
use yii\db\Migration;

class m151125_104839_topic extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%topic}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'course_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'parent_id'=>Schema::TYPE_INTEGER ,
        ], $tableOptions);
        $this->addForeignKey('topic_course', 'topic',
            'course_id', 'course', 'id');
;
        $this->addForeignKey('parent', 'topic',
            'parent_id', 'topic', 'id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%topic}}');
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
