<?php

namespace app\models\faculty;

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
    public function search($data)
    {
        $query=FacultyRecord::find()->where(['university_id'=>$data]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }
}
