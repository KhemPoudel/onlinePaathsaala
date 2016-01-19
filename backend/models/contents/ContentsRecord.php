<?php

namespace app\models\contents;

use Yii;
use yii\base\Model;

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
class ContentsRecord extends Model
{
   public $university;
    public $faculty;
    public $program;
    public $course;
    public $topic;
    public $pdf;
    public $image;
    public $video;
    public $file;
    public $name;
    public $topic_id;
    public function rules()
    {
        return [
            [['name', 'topic_id'], 'required'],
            [['topic_id'], 'integer'],
            [['pdf'],'file'],
            [['image'],'file'],
            [['video'],'file'],
            [['file'],'file'],
            [['name'], 'string', 'max' => 255]

        ];
    }


}
