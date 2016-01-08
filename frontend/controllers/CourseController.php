<?php

namespace frontend\controllers;

use Yii;
use common\models\course\CourseRecord;
//use app\models\course\CourseSearchModel;
use yii\web\Controller;
//use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CourseController implements the CRUD actions for CourseRecord model.
 */
class CourseController extends Controller
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
     * Lists all CourseRecord models.
     * @return mixed
     */
    public function actionIndex($program_id)
    {
        $model=CourseRecord::findAll(['program_id'=>$program_id]);
        return $this->render('index',['model'=>$model]);
    }
}
