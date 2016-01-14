<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "countTable".
 *
 * @property integer $id
 * @property integer $noOfLikes
 * @property integer $noOfDislikes
 * @property integer $noOfFollowers
 * @property integer $user
 *
 * @property User $user0
 */
class CountTable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'countTable';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['noOfLikes', 'noOfDislikes', 'noOfFollowers', 'user'], 'required'],
            [['noOfLikes', 'noOfDislikes', 'noOfFollowers', 'user'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'noOfLikes' => 'No Of Likes',
            'noOfDislikes' => 'No Of Dislikes',
            'noOfFollowers' => 'No Of Followers',
            'user' => 'User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }
}
