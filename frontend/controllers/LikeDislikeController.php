<?php

namespace frontend\controllers;

use Yii;
use common\models\LikeDislikeContent;
//use app\models\content\ContentSearchModel;
use yii\web\Controller;
//use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContentController implements the CRUD actions for ContentRecord model.
 */
class LikeDislikeContentController extends Controller
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
    public function actionUpdate($like_status,$present_status,$id)
    {
        if($like_status==$present_status)
            return;
        $likeOrDislike=LikeDislikeContent::findOne(['content'=>$id,'likedOrDislikedBy'=>\Yii::$app->user->identity->getId()]);
        $likeOrDislike->likeOrDislike=$like_status;
        $likeOrDislike->save();
    }
}
