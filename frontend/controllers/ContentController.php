<?php

namespace frontend\controllers;

use common\models\CommentsContent;
use common\models\FollowerUsertoUser;
use common\models\LikeDislikeContent;
use common\models\topic\TopicRecord;
use common\models\content\ContentRecord;
use common\models\FollowerProgram;
use common\models\course\CourseRecord;
use common\models\WishList;
use dektrium\user\models\User;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Query;
use yii\db\ActiveQuery;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Response;

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
    public function actionIndex($topic_id)
    {
        $profile_videos=ContentRecord::find()->where(['topic_id'=>$topic_id,'type'=>'video'])->all();
        $profile_pdf=ContentRecord::find()->where(['topic_id'=>$topic_id,'type'=>'pdf'])->all();
        $profile_img=ContentRecord::find()->where(['topic_id'=>$topic_id,'type'=>'img'])->all();
        $topic=TopicRecord::findOne($topic_id)->name;
        return $this->render('index',['topic'=>$topic,'model_videos'=>$profile_videos,'model_pdf'=>$profile_pdf,'model_img'=>$profile_img]);
    }

    public function actionViewsingle($id)
    {
        $model=ContentRecord::findOne($id);
        return $this->render('singlecontent',['model'=>$model]);
    }

    public function getComments($model)
    {
        $query = CommentsContent::find()->where(['commentedOn'=>$model->id]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->renderPartial('_comments',['models'=>$models,'id'=>$model->id,'pages'=>$pages]);
    }

    public function getLikes($model)
    {
        $likes=LikeDislikeContent::find()->where(['content'=>$model->id,'likeOrDislike'=>1]);
        return $likes->count();
    }

    public function getDislikes($model)
    {
        $likes=LikeDislikeContent::find()->where(['content'=>$model->id,'likeOrDislike'=>0]);
        return $likes->count();
    }

    public function IfLikedByUser($model)
    {
        $likeOrDislike=LikeDislikeContent::findOne(['content'=>$model->id,'likedOrDislikedBy'=>\Yii::$app->user->identity->getId()]);
        if($likeOrDislike==null)
        {
            return -1;
        }
        return $likeOrDislike->likeOrDislike;
    }

    public function actionUpdate()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post();
            $like_status=  $data['like_status'];
            $present_status= $data['present_status'];
            $id= $data['id'];
            //echo $data;
            if($like_status!=$present_status) {
                if($like_status==-1)
                {
                    $likeOrDislike=new LikeDislikeContent();
                    $likeOrDislike->content=$id;
                    $likeOrDislike->likedOrDislikedBy=\Yii::$app->user->identity->getId();
                    $likeOrDislike->likeOrDislike=$present_status;
                    $likeOrDislike->save();
                }
                else {
                    $likeOrDislike = LikeDislikeContent::findOne(['content' => $id, 'likedOrDislikedBy' => \Yii::$app->user->identity->getId()]);
                    $likeOrDislike->likeOrDislike = $present_status;
                    $likeOrDislike->save();
                }
            }
            else
            {
                $likeOrDislike = LikeDislikeContent::findOne(['content' => $id, 'likedOrDislikedBy' => \Yii::$app->user->identity->getId()]);
                $likeOrDislike->delete();
            }
            $likes=LikeDislikeContent::find()->where(['content'=>$id,'likeOrDislike'=>1]);
            $dislikes=LikeDislikeContent::find()->where(['content'=>$id,'likeOrDislike'=>0]);
            $likeOrDislike=LikeDislikeContent::findOne(['content'=>$id,'likedOrDislikedBy'=>\Yii::$app->user->identity->getId()]);
            if($likeOrDislike==null)
            {
                $new_like_status=-1;
            }
            else
                $new_like_status=$likeOrDislike->likeOrDislike;
            return ['new_like_status'=>$new_like_status,'new_id'=>$id,'likes'=>$likes->count(),'dislikes'=>$dislikes->count()];
        }

    }

    public function actionAddcomment()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post();
            $comment = $data['comment'];
            $commentedOn=$data['commentedOn'];
            $model=new CommentsContent();
            $model->comment=$comment;
            $model->commentedOn=$commentedOn;
            $model->commentedBy=\Yii::$app->user->identity->getId();
            $model->commentedAt=time();
            if($model->save())
            {
                return [
                    'comment'=>$comment,
                    'commentedOn'=>$commentedOn,
                    'commentedBy'=>User::findOne(['id'=>\Yii::$app->user->identity->getId()])->username,
                    'commentedAt'=>Yii::t('user', '{0, date}', time())
                ];
            }
        }
    }


    public function actionAddwish()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post();
            $id = $data['id'];
            $status=$data['status'];
            if($status=='1')
            {
                $model=new WishList();
                $model->content=$id;
                $model->wishedBy=\Yii::$app->user->identity->getId();
                $model->save();

            }
            else
            {
                $model=WishList::findOne(['content'=>$id,'wishedBy'=>\Yii::$app->user->identity->getId()]);
                $model->delete();

            }
            return 0;
        }
    }

    public function ifWished($id)
    {
        $modelWish=WishList::findOne(['content'=>$id,'wishedBy'=>\Yii::$app->user->identity->getId()]);
        if($modelWish==null)
            return 1;
        else
            return 0;
    }
}


