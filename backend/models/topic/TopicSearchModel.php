<?php

namespace app\models\topic;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\topic\TopicRecord;
use yii\db\ActiveRecord;

/**
 * TopicSearchModel represents the model behind the search form about `app\models\topic\TopicRecord`.
 */
class TopicSearchModel extends TopicRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'course_id', 'parent_id', 'level'], 'integer'],
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
        $query=TopicRecord::find()->where(['course_id'=>$id,'level'=>1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }
    public function subSearch($level,$parent_id)
    {

        $query=TopicRecord::find()->where(['level'=>$level,'parent_id'=>$parent_id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }
    public function topSearch($course_id)
    {
        $level=1;
        $query=TopicRecord::find()->where(['level'=>$level,'course_id'=>$course_id]);
        $dataProvider=new ActiveDataProvider([
            'query'=>$query,
        ]);
        return $dataProvider;
    }
    public function topicSearch($id)
    {
        $query=TopicRecord::find()->where(['parent_id'=>$id]);
        $dataProvider=new ActiveDataProvider([
            'query'=>$query,
        ]);
        return $dataProvider;

    }
}
