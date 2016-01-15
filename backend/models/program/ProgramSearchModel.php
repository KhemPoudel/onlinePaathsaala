<?php

namespace app\models\program;

use app\models\faculty\FacultyRecord;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\program\ProgramRecord;

/**
 * ProgramSearchModel represents the model behind the search form about `app\models\program\ProgramRecord`.
 */
class ProgramSearchModel extends ProgramRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'faculty_id'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($id)
    {
        $query=ProgramRecord::find()->where(['faculty_id'=>$id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }
}
