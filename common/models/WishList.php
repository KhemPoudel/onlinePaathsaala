<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wishList".
 *
 * @property integer $id
 * @property integer $content
 * @property integer $wishedBy
 *
 * @property Content $content0
 * @property User $wishedBy0
 */
class WishList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wishList';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'wishedBy'], 'required'],
            [['content', 'wishedBy'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'wishedBy' => 'Wished By',
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
    public function getWishedBy0()
    {
        return $this->hasOne(User::className(), ['id' => 'wishedBy']);
    }
}
