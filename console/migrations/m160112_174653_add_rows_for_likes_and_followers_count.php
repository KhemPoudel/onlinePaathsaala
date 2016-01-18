<?php

use yii\db\Schema;
use yii\db\Migration;

class m160112_174653_add_rows_for_likes_and_followers_count extends Migration
{
    public function up()
    {
        $this->addColumn('user','noOLikes','INT NOT NULL DEFAULT 0');
        $this->addColumn('user','noOfFollowers','INT NOT NULL DEFAULT 0');
        $this->addColumn('user','noOfDislikes','INT NOT NULL DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('user','noOLikes');
        $this->dropColumn('user','noOfFollowers');
        $this->dropColumn('user','noOfDislikes');
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
