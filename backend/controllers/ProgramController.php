<?php

namespace backend\controllers;

use app\models\faculty\FacultyRecord;
use Yii;
use app\models\program\ProgramRecord;
use app\models\program\ProgramSearchModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;


/**
 * ProgramController implements the CRUD actions for ProgramRecord model
 *
 */
$count=0;
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
    public function actionIndex($id)
    {
        $searchModel = new ProgramSearchModel();
        $dataProvider = $searchModel->search($id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProgramRecord model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProgramRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {


        $model = new ProgramRecord();
//$faculty_id=$id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['create', 'id' => $id,]
            );
        } else {
            return $this->render('create', [
                'model' => $model,
                'id'=>$id,
            ]);
        }
    }
    public function actionNext($faculty_id)
    {

        return $this->redirect(['faculty/index','faculty_id'=>$faculty_id]);
    }
public function actionBack($id)
{

    $model=FacultyRecord::findOne($id);
   $university_id=$model->university_id;
    return $this->redirect(['faculty/index','id'=>$university_id]);
}
    /**
     * Updates an existing ProgramRecord model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
//$faculty_id=$model->faculty_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,


            ]);
        }
    }

    /**
     * Deletes an existing ProgramRecord model.
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
     * Finds the ProgramRecord model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProgramRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProgramRecord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
