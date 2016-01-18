<?php

namespace backend\controllers;

use common\models\course\CourseRecord;
use Yii;
use app\models\topic\TopicRecord;
use app\models\topic\TopicSearchModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
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
    public function actionIndex($id)
    {
        $searchModel = new TopicSearchModel();
        $dataProvider = $searchModel->search($id);
        $model=CourseRecord::findOne($id);
        $num=0;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
           'id'=>$id,
            'model'=>$model,
            'num'=>$num,
        ]);
    }
public function actionInitial($num,$model)
{
if ($num!=2)
{
    $id=$model;
    $course=CourseRecord::findOne($id);
    $id=$course->program_id;
    return $this->redirect(['/course/index', 'id' => $id,]) ;
}
    else
    {
        $id=$model;
       $topic=TopicRecord::findOne($id);
        if($topic->level==1)
        {
            $this->redirect(['index','id'=>$topic->course_id]);
        }
        else
        {
            $id=$model;
            $topic=TopicRecord::findOne($id);
            $this->redirect(['sub','level'=>$topic->level,'par'=>$id,'course_id'=>$topic->course_id]);
        }
    }
}
    /**
     * Displays a single TopicRecord model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

public function actionProvider($id)
{
    $model=TopicRecord::findOne($id);
    $level=$model->level;
   $level++;
    $course_id=$model->course_id;
    return $this->redirect(['create',
        'parent_id'=>$id,
        'level'=>$level,
        'course_id'=>$course_id,
    ]);
}
    /**
     * Creates a new TopicRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($parent_id,$level,$course_id)
    {
        $model = new TopicRecord();
        $model->parent_id=$parent_id;
        $model->course_id=$course_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['create','parent_id'=>$parent_id,'level'=>$level,'course_id'=>$course_id]);
        } else {

            return $this->render('create', [
                'model' => $model,
                'parent_id'=>$parent_id,
                'level'=>$level,
                'course_id'=>$course_id,

            ]);
        }
    }

    /**
     * Updates an existing TopicRecord model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionBack($level,$parent_id,$course_id)
    {
        if($level<=2)
        {
            $this->redirect(['top','course_id'=>$course_id]);
        }
        else
        {
            $level--;

            $this->redirect(['sub','level'=>$level,'par'=>$parent_id,'course_id'=>$course_id]);
        }
    }
    public function actionSub($level,$par,$course_id)
    {
        $searchModel = new TopicSearchModel();
        $id=$par;
        $model=TopicRecord::findOne($id);
        $parent_id=$model->parent_id;
        $dataProvider = $searchModel->subSearch($level,$parent_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id'=>$course_id,
            'model'=>$model,
            'num'=>2,

        ]);

    }
    public function actionTop($course_id)
    {
        $searchModel = new TopicSearchModel();
        $dataProvider = $searchModel->topSearch($course_id);
$id=$course_id;
        $model=CourseRecord::findOne($id);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id'=>$course_id,
            'model'=>$model,
            'num'=>1,

        ]);
    }
    public function  actionShow($id)
{
    $searchModel = new TopicSearchModel();
    $dataProvider = $searchModel->topicSearch($id);
    $model=TopicRecord::findOne($id);

    $course_id=$model->course_id;

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'id'=>$course_id,
        'model'=>$model,
        'num'=>2

    ]);
}

    /**
     * Deletes an existing TopicRecord model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TopicRecord model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TopicRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TopicRecord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
