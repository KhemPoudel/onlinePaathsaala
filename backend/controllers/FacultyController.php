<?php

namespace backend\controllers;

use app\models\university\UniversityRecord;
use Yii;
use app\models\faculty\FacultyRecord;
use app\models\faculty\FacultySearchModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
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
    public function actionIndex($id)
    {
$data=$id;
        $searchModel = new FacultySearchModel();
        $dataProvider = $searchModel->search($data);
//$faculty_id=$dataProvider->id;
        $name=UniversityRecord::findOne($data);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,


        ]);
    }

    /**
     * Displays a single FacultyRecord model.
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
     * Creates a new FacultyRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate($id)
    {
        $model = new FacultyRecord();
$dataProvider=$id;
    if ($model->load(Yii::$app->request->post()) && $model->save()) {

        return $this->redirect(['create', 'id' => $id,
            'dataProvider' => $dataProvider]);
    } else {
        //$dataProvider='1';
        return $this->render('create', [
            'model' => $model,
            'dataProvider' => $dataProvider,

        ]);
    }

    }
    public function actionNext($dataProvider)
    {
        $id=$dataProvider;
        return $this->redirect(['faculty/index','id'=>$id]);
    }

    /**
     * Updates an existing FacultyRecord model.
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

    /**
     * Deletes an existing FacultyRecord model.
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
     * Finds the FacultyRecord model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FacultyRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FacultyRecord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
