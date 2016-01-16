<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "followerUsertoUser".
 *
 * @property integer $id
 * @property integer $follower_user_id
 * @property integer $followed_user_id
 *
 * @property User $followedUser
 * @property User $followerUser
 */
class FollowerUsertoUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'followerUsertoUser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['follower_user_id', 'followed_user_id'], 'required'],
            [['follower_user_id', 'followed_user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'follower_user_id' => 'Follower User ID',
            'followed_user_id' => 'Followed User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollowedUser()
    {
        return $this->hasOne(User::className(), ['id' => 'followed_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollowerUser()
    {
        return $this->hasOne(User::className(), ['id' => 'follower_user_id']);
    }
}
