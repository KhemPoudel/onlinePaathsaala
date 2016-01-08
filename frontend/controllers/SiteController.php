<?php
namespace frontend\controllers;

use common\models\CommentsContent;
use common\models\FollowerUsertoUser;
use common\models\LikeDislikeContent;
use common\models\topic\TopicRecord;
use common\models\content\ContentRecord;
use common\models\FollowerProgram;
use common\models\course\CourseRecord;
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

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index','about','contact','update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $user_id=\Yii::$app->user->identity->getId();
        //echo \Yii::$app->user->identity->getId();
        $followed_programs=FollowerProgram::find()->where(['user_id'=>$user_id])->all();
        $followed_users=FollowerUsertoUser::find()->where(['follower_user_id'=>$user_id])->all();
        $followed_users_ids=ArrayHelper::getColumn($followed_users,'followed_user_id');
        $followed_programs_ids=ArrayHelper::getColumn($followed_programs,'program_id');
        $courses=CourseRecord::find()->where(['program_id' =>$followed_programs_ids])->all();
        $course_ids=ArrayHelper::getColumn($courses,'id');
        $topics=TopicRecord::find()->where(['course_id'=>$course_ids])->all();
        $topics_ids=ArrayHelper::getColumn($topics,'id');
            $query = ContentRecord::find()->where(['topic_id' =>$topics_ids])->orWhere(['uploadedBy'=>$followed_users_ids]);
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count()]);
            $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

        return $this->render('index',['models'=>$models,'pages'=>$pages]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function getComments($model)
    {
        $query = CommentsContent::find()->where(['commentedOn'=>$model->id]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->renderPartial('_comments',['models'=>$models]);
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
        /*if($like_status!=$present_status) {
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
        //return $this->render('index',['models'=>$models,'pages'=>$pages]);
        $model=ContentRecord::findOne(['id'=>$id]);
        return $this->render(['_likedislike','model'=>$model]);
*/
        //if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $like_status=  $data['like_status'];
            $present_status= $data['present_status'];
            $id= $data['id'];
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
            return 1;
        //}
    }

}
