<?php

use yii\db\Schema;
use yii\db\Migration;

class m160117_205338_add_address_to_content_table extends Migration
{
    public function up()
    {
        $this->addColumn('content','address','VARCHAR(100)');
    }

    public function down()
    {
        $this->dropColumn('content','address');
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
