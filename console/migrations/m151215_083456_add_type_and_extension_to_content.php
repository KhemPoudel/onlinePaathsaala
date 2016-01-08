<?php

use yii\db\Schema;
use yii\db\Migration;

class m151215_083456_add_type_and_extension_to_content extends Migration
{
    public function up()
    {
        $this->addColumn('content','type','VARCHAR(20)');
        $this->addColumn('content','ext','VARCHAR(20)');
    }

    public function down()
    {
        $this->dropColumn('content','type');
        $this->dropColumn('content','ext');
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
