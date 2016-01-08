<?php

namespace frontend\controllers;

//use app\models\university\UniversityRecord;
use Yii;
use common\models\university\UniversityRecord;
//use app\models\university\UniversitySearchModel;
use yii\web\Controller;
//use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class UniversityController extends Controller
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

    public function actionIndex()
    {
        $model=UniversityRecord::find()->all();
        return $this->render('index',['model'=>$model]);
    }
}