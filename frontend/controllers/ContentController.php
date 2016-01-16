<?php

namespace frontend\controllers;

use Yii;
use common\models\content\ContentRecord;
//use app\models\content\ContentSearchModel;
use yii\web\Controller;
//use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContentController implements the CRUD actions for ContentRecord model.
 */
class ContentController extends Controller
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
     * Lists all ContentRecord models.
     * @return mixed
     */
    public function actionIndex($content_id)
    {
        $model=ContentRecord::findAll(['topic_id'=>$content_id]);
        return $this->render('index',['model'=>$model]);
    }
}
