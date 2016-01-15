<?php

use yii\db\Schema;
use yii\db\Migration;

class m160112_180118_add_rows_for_likes_and_followers_count_in_program extends Migration
{
    public function up()
    {
        $this->addColumn('program','noOLikes','INT NOT NULL DEFAULT 0');
        $this->addColumn('program','noOfFollowers','INT NOT NULL DEFAULT 0');
        $this->addColumn('program','noOfDislikes','INT NOT NULL DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('program','noOfLikes');
        $this->dropColumn('program','noOfFollowers');
        $this->dropColumn('program','noOfDislikes');
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
