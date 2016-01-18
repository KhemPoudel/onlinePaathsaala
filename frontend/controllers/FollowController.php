<?php

namespace frontend\controllers;

use common\models\program\ProgramRecord;
use dektrium\user\models\User;
use Yii;
use common\models\FollowerUsertoUser;
use common\models\FollowerProgram;
//use app\models\content\ContentSearchModel;
use yii\web\Controller;
//use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;
use yii\filters\AccessControl;

/**
 * ContentController implements the CRUD actions for ContentRecord model.
 */
class FollowController extends Controller
{
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout', 'signup'],
                'rules' => [

                    [
                        'actions' => ['followings','followers','followedprograms','addfollower','removeoraddfollow'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
    public function actionFollowers($id)
    {
        $follower=FollowerUsertoUser::find()->where(['followed_user_id'=>$id])->all();
        $follower_users_ids=ArrayHelper::getColumn($follower,'follower_user_id');
        $query = User::find()->where(['id'=>$follower_users_ids]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index',['models'=>$models,'caller'=>$id,'callerType'=>'Followers']);
    }

    public function actionFollowings($id)
    {
        $followings=FollowerUsertoUser::find()->where(['follower_user_id'=>$id])->all();
        $following_users_ids=ArrayHelper::getColumn($followings,'followed_user_id');
        $query = User::find()->where(['id'=>$following_users_ids]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index',['models'=>$models,'caller'=>$id,'callerType'=>'Followings']);
    }

    public function actionFollowedprograms($id)
    {
        $followings=FollowerProgram::find()->where(['user_id'=>$id])->all();
        $following_programs_ids=ArrayHelper::getColumn($followings,'program_id');
        $query = ProgramRecord::find()->where(['id'=>$following_programs_ids]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('showFollowedPrograms',['models'=>$models,'caller'=>$id]);
    }

    public function ifFollowerIsFollowedByCurrentUser($follower_id)
    {
        $follow_record=FollowerUsertoUser::findOne(['followed_user_id'=>$follower_id,'follower_user_id'=>\Yii::$app->user->identity->getId()]);
        if($follow_record==null)
        {
            return 0;
        }
        return 1;
    }

    public function actionAddfollower()
    {
        if (Yii::$app->request->isAjax) {
            $return_message=-1;
            $data = Yii::$app->request->post();
            $followed_id = $data['followed_id'];
            $follow_status = $data['follow_status'];
            if($follow_status=='Follow')
            {
                $follow=new FollowerUsertoUser();
                $follow->followed_user_id=$followed_id;
                $follow->follower_user_id=\Yii::$app->user->identity->getId();
                if($follow->save())
                {
                        $return_message=0;
                }

            }
            else
            {
                $follow_record=FollowerUsertoUser::findOne(['followed_user_id'=>$followed_id,'follower_user_id'=>\Yii::$app->user->identity->getId()]);
                if($follow_record->delete())
                {
                        $return_message=1;
                }

            }
            return $return_message;
        }

    }

    public function ifProgramIsFollowedByCurrentUser($program_id)
    {
        $program_record=FollowerProgram::findOne(['program_id'=>$program_id,'user_id'=>\Yii::$app->user->identity->getId()]);
        if($program_record==null)
        {
            return 0;
        }
        return 1;
    }
    public function actionRemoveoraddfollow() //for program follow
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $program_id = $data['program_id'];
            $follow_status=$data['follow_status'];
            $program=ProgramRecord::findOne($program_id);

            if($follow_status=='Follow')
            {
                $follow_program=new FollowerProgram();
                $follow_program->program_id=$program_id;
                $follow_program->user_id=\Yii::$app->user->identity->getId();
                if($follow_program->save())
                {
                    $program->noOfFollowers+=1;
                    $program->save();
                    $return_message=0;
                }
            }
            else
            {
                $follow_program=FollowerProgram::findOne(['program_id'=>$program_id,'user_id'=>\Yii::$app->user->identity->getId()]);
                if($follow_program->delete())
                {

                    $program->noOfFollowers-=1;
                    $program->save();
                    $return_message=1;
                }
            }
            return $return_message;

        }
    }
}
