<?php

use yii\db\Schema;
use yii\db\Migration;

class m160111_093852_add_level_to_topic extends Migration
{
    public function up()
    {
        $this->addColumn('topic','level','INTEGER');
    }

    public function down()
    {
        $this->dropColumn('topic','level');
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
