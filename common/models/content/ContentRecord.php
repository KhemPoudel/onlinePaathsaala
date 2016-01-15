<?php

namespace common\models\content;

use common\models\LikeDislikeContent;
use Yii;

/**
 * This is the model class for table "content".
 *
 * @property integer $id
 * @property string $name
 * @property integer $topic_id
 * @property string $type
 * @property string $ext
 *
 * @property Topic $topic
 * @property FollowerContent[] $followerContents
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
    public function rules()
    {
        return [
            [['name', 'topic_id'], 'required'],
            [['topic_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['type', 'ext'], 'string', 'max' => 20]
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollowerPrograms()
    {
        return $this->hasMany(FollowerProgram::className(), ['program_id' => 'id']);
    }

    public function getLikesDislikes()
    {
        return $this->hasMany(LikeDislikeContent::className(), ['content' => 'id']);
    }
}
