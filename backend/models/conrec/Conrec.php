<?php

namespace app\models\conrec;

use Yii;

/**
 * This is the model class for table "conrec".
 *
 * @property integer $id
 * @property string $name
 * @property integer $topic_id
 * @property string $type
 * @property string $ext
 * @property integer $uploadedBy
 * @property string $address
 * @property string $postedAt
 * @property integer $flag
 */
class Conrec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'conrec';
    }
public $university;
public $faculty;
    public $program;
    public $course;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'topic_id', 'type', 'ext', 'uploadedBy', 'address', 'postedAt', 'flag'], 'required'],
            [['topic_id', 'uploadedBy', 'flag'], 'integer'],
            [['postedAt'], 'safe'],
            [['name'], 'string', 'max' => 224],
            [['type', 'ext'], 'string', 'max' => 244],
            [['address'], 'string', 'max' => 500],
            [['university'], 'string', 'max' => 500],
            [['faculty'], 'string', 'max' => 500],
            [['program'], 'string', 'max' => 500],
            [['course'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'topic_id' => 'Topic ID',
            'type' => 'Type',
            'ext' => 'Ext',
            'uploadedBy' => 'Uploaded By',
            'address' => 'Address',
            'postedAt' => 'Posted At',
            'flag' => 'Flag',
        ];
    }
}
