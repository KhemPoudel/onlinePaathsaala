<?php

namespace frontend\controllers;

use Yii;
use common\models\faculty\FacultyRecord;
//use app\models\faculty\FacultySearchModel;
use yii\web\Controller;
//use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FacultyController implements the CRUD actions for FacultyRecord model.
 */
class FacultyController extends Controller
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
     * Lists all FacultyRecord models.
     * @return mixed
     */
    public function actionIndex($university_id)
    {
        $models=FacultyRecord::findAll(['university_id'=>$university_id]);
        return $this->render('index',['models'=>$models,'university_id'=>$university_id]);

    }
}