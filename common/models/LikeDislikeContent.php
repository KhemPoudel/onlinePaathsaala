<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "likeDislikeContent".
 *
 * @property integer $id
 * @property integer $likeOrDislike
 * @property integer $likedOrDislikedBy
 * @property integer $content
 *
 * @property Content $content0
 * @property User $likedOrDislikedBy0
 */
class LikeDislikeContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'likeDislikeContent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['likeOrDislike', 'likedOrDislikedBy', 'content'], 'required'],
            [['likeOrDislike', 'likedOrDislikedBy', 'content'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'likeOrDislike' => 'Like Or Dislike',
            'likedOrDislikedBy' => 'Liked Or Disliked By',
            'content' => 'Content',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent0()
    {
        return $this->hasOne(Content::className(), ['id' => 'content']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLikedOrDislikedBy0()
    {
        return $this->hasOne(User::className(), ['id' => 'likedOrDislikedBy']);
    }
}
