<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "commentsContent".
 *
 * @property integer $id
 * @property string $comment
 * @property integer $commentedBy
 * @property integer $commentedOn
 *
 * @property Content $commentedOn0
 * @property User $commentedBy0
 */
class CommentsContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'commentsContent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment', 'commentedBy', 'commentedOn'], 'required'],
            [['commentedBy', 'commentedOn'], 'integer'],
            [['comment'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comment' => 'Comment',
            'commentedBy' => 'Commented By',
            'commentedOn' => 'Commented On',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommentedOn0()
    {
        return $this->hasOne(Content::className(), ['id' => 'commentedOn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommentedBy0()
    {
        return $this->hasOne(User::className(), ['id' => 'commentedBy']);
    }
}
