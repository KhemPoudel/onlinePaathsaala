<?php

namespace app\models\content;
use Yii;

/**
 * This is the model class for table "content".
 *
 * @property integer $id
 * @property string $name
 * @property integer $topic_id
 *
 * @property Topic $topic
 */
class ContentRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content';
    }

    /**
     * @inheritdoc
     */
    public $pdf;
    public $image;
    public $video;
    public $file;
    public function rules()
    {
        return [
            [['name', 'topic_id'], 'required'],
            [['topic_id'], 'integer'],
            [['pdf'],'file'],
            [['image'],'file'],
            [['video'],'file'],
            [['file'],'file'],
            [['name'], 'string', 'max' => 255],
            [['address'],'string','max'=>400]
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }
}
