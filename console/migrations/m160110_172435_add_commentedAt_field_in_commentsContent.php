<?php

use yii\db\Schema;
use yii\db\Migration;

class m160110_172435_add_commentedAt_field_in_commentsContent extends Migration
{
    public function up()
    {
        $this->addColumn('commentsContent','commentedAt','INT NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('commentsContent','commentedAt');
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
