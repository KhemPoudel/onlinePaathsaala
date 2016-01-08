<?php

namespace app\models\university;

use Yii;

/**
 * This is the model class for table "university".
 *
 * @property integer $id
 * @property string $name
 * @property string $location
 *
 * @property Faculty[] $faculties
 */
class UniversityRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'university';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'location'], 'required'],
            [['name', 'location'], 'string', 'max' => 255]
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
            'location' => 'Location',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaculties()
    {
        return $this->hasMany(Faculty::className(), ['university_id' => 'id']);
    }
}
