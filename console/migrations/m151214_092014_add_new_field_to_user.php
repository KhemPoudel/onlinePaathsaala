<?php

use yii\db\Schema;
use yii\db\Migration;

class m151214_092014_add_new_field_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('user','role','INTEGER DEFAULT 10');
    }

    public function down()
    {
        $this->dropColumn('user','role');
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
