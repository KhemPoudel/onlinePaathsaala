<?php

use yii\db\Schema;
use yii\db\Migration;

class m151222_072933_add_field_uploaded_by_in_content_table extends Migration
{
    public function up()
    {
        $this->addColumn('content','uploadedBy','INT NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('content','uploadedBy');
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
