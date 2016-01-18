<?php

use yii\db\Schema;
use yii\db\Migration;

class m160117_211431_add_flag_and_time_to_content_table extends Migration
{
    public function up()
    {
        $this->addColumn('content','posted_at','INT NOT NULL');
        $this->addColumn('content','flag','INT NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('content','posted_at');
        $this->dropColumn('content','flag');
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
