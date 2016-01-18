<?php

namespace frontend\controllers;

use common\models\course\CourseRecord;
use common\models\program\ProgramRecord;
use common\models\university\UniversityRecord;
use common\models\faculty\FacultyRecord;
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
    public function actionIndex($course_id,$university,$faculty,$program)
    {
        $model=TopicRecord::findAll(['course_id'=>$course_id]);
        //$university=UniversityRecord::findOne(['id'=>$university])->name;
        //$faculty=FacultyRecord::findOne($faculty)->name;
        $course=CourseRecord::findOne($course_id)->name;
        return $this->render('index',['model'=>$model,'university'=>$university,'faculty'=>$faculty,'program'=>$program,'course'=>$course]);
    }

    public function renderChild($model)
    {
        $i=0;
        if($model->level==0)
        {
            $font='bolder';
        }
        elseif($model->level==1)
        {
            $font='bold';
        }
        else
        {
            $font='normal';
        }
        $link='<span style="color:#111111;font-weight:'.$font.'">'.$model->name.'</span>';
        echo Html::a($link,['/content/index','topic_id'=>$model->id]),'<br>';
        foreach($model->topicRecords as $childRecord)
        {
            $i++;
            $margin=50*$childRecord->level.'px';
            echo '<span style="color:#111111;margin-left:'.$margin.'">'.$i.')'.'</span>';
            $this->renderChild($childRecord);
        }
    }
}
