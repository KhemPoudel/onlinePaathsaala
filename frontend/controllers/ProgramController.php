<?php

namespace frontend\controllers;

use common\models\course\CourseRecord;
use common\models\topic\TopicRecord;
use Yii;
use common\models\program\ProgramRecord;
use common\models\content\ContentRecord;
//use app\models\program\ProgramSearchModel;
use yii\helpers\ArrayHelper;
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
    public function actionIndex($faculty_id,$university)
    {
        $models=ProgramRecord::findAll(['faculty_id'=>$faculty_id]);
        return $this->render('index',['models'=>$models,'university'=>$university,'faculty_id'=>$faculty_id]);
    }

    public function actionShow($id)
    {
        $program=ProgramRecord::findOne($id);
        $courses=CourseRecord::find()->where(['program_id'=>$id])->all();
        $course_ids=ArrayHelper::getColumn($courses,'id');
        $topics=TopicRecord::find()->where(['course_id'=>$course_ids])->all();
        $topic_ids=ArrayHelper::getColumn($topics,'id');
        $program_videos=ContentRecord::find()->where(['topic_id'=>$topic_ids,'type'=>'video'])->all();
        $program_pdf=ContentRecord::find()->where(['topic_id'=>$topic_ids,'type'=>'pdf'])->all();
        $program_img=ContentRecord::find()->where(['topic_id'=>$topic_ids,'type'=>'img'])->all();
        return $this->render('show',[
            'model_videos' => $program_videos,
            'model_pdf'=>$program_pdf,
            'model_img'=>$program_img,
            'id'=>$id,
            'program'=>$program,
        ]);
    }

}
