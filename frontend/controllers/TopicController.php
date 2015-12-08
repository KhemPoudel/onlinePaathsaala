<?php

namespace frontend\controllers;

use Yii;
use common\models\topic\TopicRecord;
//use app\models\topic\TopicSearchModel;
use yii\web\Controller;
use yii\helpers\Html;
//use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TopicController implements the CRUD actions for TopicRecord model.
 */
class TopicController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all TopicRecord models.
     * @return mixed
     */
    public function actionIndex($course_id)
    {
        $model=TopicRecord::findAll(['course_id'=>$course_id]);
        return $this->render('index',['model'=>$model]);
    }

    public function renderChild($model)
    {
        echo '<ul><li>',Html::a($model->name, ['/content/index','content_id'=>$model->id]),'</li>';
        if(empty($model->topicRecords))
        {
            echo str_repeat('</ul>', 2);
        }
        foreach($model->topicRecords as $childRecord)
        {
            $this->renderChild($childRecord);
        }
    }
}
