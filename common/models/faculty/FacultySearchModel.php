<?php

namespace common\models\faculty;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\faculty\FacultyRecord;

/**
 * FacultySearchModel represents the model behind the search form about `app\models\faculty\FacultyRecord`.
 */
class FacultySearchModel extends FacultyRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'university_id'], 'integer'],
            [['name', 'level'], 'safe'],
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
    public function search($params)
    {
        $query = FacultyRecord::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'university_id' => $this->university_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'level', $this->level]);

        return $dataProvider;
    }
}
