<?php

namespace backend\controllers;

use Yii;
use app\models\content\ContentRecord;
use app\models\content\ContentSearchModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


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
    public function actionUpload($id)
    {
        return $this->render('upload',[
            'id'=>$id,
        ]);
    }
    public function actionIndex()
    {
        $searchModel = new ContentSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ContentRecord model.
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
     * Creates a new ContentRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($label,$id)
    {
        $model = new ContentRecord();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $imageName=$model->name;
            //get the instance of uploaded file
            $target=md5(uniqid());
            $model->$label=UploadedFile::getInstance($model,$label);
            $model->$label->saveAs('Uploads/'.$target.'.'.$model->$label->extension);
// save the path in db
            $model->name=$imageName.'.'.$model->$label->extension;
            $model->address=$target.'.'.$model->$label->extension;
            $model->ext=$model->$label->extension;
            $model->uploadedBy=Yii::$app->user->identity->getId();
            if($model->ext=='jpg'||$model->ext=='jpeg'||$model->ext=='gif'||$model->ext=='png')
                $model->type='img';
            elseif($model->ext=='pdf')
                $model->type='pdf';
            else
                $model->type='video';
            $model->posted_at=time();
            $model->flag=1;
            $model->save();


            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'label'=>$label,
                'topic_id'=>$id,
            ]);
        }
    }

    /**
     * Updates an existing ContentRecord model.
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
     * Deletes an existing ContentRecord model.
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
     * Finds the ContentRecord model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ContentRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ContentRecord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
