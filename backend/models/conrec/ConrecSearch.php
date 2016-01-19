<?php

namespace app\models\conrec;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\conrec\Conrec;

/**
 * ConrecSearch represents the model behind the search form about `app\models\conrec\Conrec`.
 */
class ConrecSearch extends Conrec
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'topic_id', 'uploadedBy', 'flag'], 'integer'],
            [['name', 'type', 'ext', 'address', 'postedAt'], 'safe'],
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
        $query = Conrec::find();
foreach($query as $que)
{


}
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
            'topic_id' => $this->topic_id,
            'uploadedBy' => $this->uploadedBy,
            'postedAt' => $this->postedAt,
            'flag' => $this->flag,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'ext', $this->ext])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
