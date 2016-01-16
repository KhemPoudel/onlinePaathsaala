<?php

namespace frontend\controllers;

use Yii;
use common\models\program\ProgramRecord;
//use app\models\program\ProgramSearchModel;
use yii\web\Controller;
//use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProgramController implements the CRUD actions for ProgramRecord model.
 */
class ProgramController extends Controller
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
     * Lists all ProgramRecord models.
     * @return mixed
     */
    public function actionIndex($faculty_id)
    {
        $model=ProgramRecord::findAll(['faculty_id'=>$faculty_id]);
        return $this->render('index',['model'=>$model]);
    }

}
