<?php

namespace app\models\contents;

use Yii;

/**
 * This is the model class for table "course".
 *
 * @property integer $id
 * @property string $name
 * @property integer $program_id
 *
 * @property Program $program
 * @property Topic[] $topics
 */
class ContentsRecord extends \yii\db\ActiveRecord
{
   public $university;
    public $faculty;
    public $program;
    public $course;
    public $topic;

}
