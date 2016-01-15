<?php

namespace common\models\faculty;

use Yii;

/**
 * This is the model class for table "faculty".
 *
 * @property integer $id
 * @property string $name
 * @property string $level
 * @property integer $university_id
 *
 * @property University $university
 * @property Program[] $programs
 */
class FacultyRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faculty';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'level', 'university_id'], 'required'],
            [['university_id'], 'integer'],
            [['name', 'level'], 'string', 'max' => 255]
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
            'level' => 'Level',
            'university_id' => 'University ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniversity()
    {
        return $this->hasOne(University::className(), ['id' => 'university_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrograms()
    {
        return $this->hasMany(Program::className(), ['faculty_id' => 'id']);
    }
}
