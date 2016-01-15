<?php
namespace frontend\controllers;

use common\models\CommentsContent;
use common\models\FollowerUsertoUser;
use common\models\LikeDislikeContent;
use common\models\program\ProgramRecord;
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
                        'actions' => ['index','about','contact','update','addcomment','addwish','download'],
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
            $query = ContentRecord::find()->where(['topic_id' =>$topics_ids])->orWhere(['uploadedBy'=>$followed_users_ids])->orderBy('id DESC');
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count()]);
            $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        if(empty($models))
        {
            $models=$this->findSuggestions();
        }
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
        $query = CommentsContent::find()->where(['commentedOn'=>$model->id])->orderBy('commentedAt DESC');
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
            //for finding program of content
            $topic_id=ContentRecord::findOne($id)->topic_id;
            $course_id=TopicRecord::findOne($topic_id)->course_id;
            $program_id=CourseRecord::findOne($course_id)->program_id;
            $program=ProgramRecord::findOne($program_id);
            //end of finding program of content
            if($like_status!=$present_status) {
                if($like_status==-1)
                {
                    $likeOrDislike=new LikeDislikeContent();
                    $likeOrDislike->content=$id;
                    $likeOrDislike->likedOrDislikedBy=\Yii::$app->user->identity->getId();
                    $likeOrDislike->likeOrDislike=$present_status;
                    $likeOrDislike->save();
                    //for program like counter
                    if($present_status==0)
                        $program->noOfDislikes+=1;
                    else
                        $program->noOLikes+=1;
                    $program->save();

                }
                else {
                    $likeOrDislike = LikeDislikeContent::findOne(['content' => $id, 'likedOrDislikedBy' => \Yii::$app->user->identity->getId()]);
                    $likeOrDislike->likeOrDislike = $present_status;
                    $likeOrDislike->save();

                    //for program counter
                    if($present_status==0)
                    {
                        $program->noOfDislikes+=1;
                        $program->noOLikes-=1;
                    }
                    else
                    {
                        $program->noOfDislikes-=1;
                        $program->noOLikes+=1;
                    }
                    $program->save();
                }
            }
            else
            {
                $likeOrDislike = LikeDislikeContent::findOne(['content' => $id, 'likedOrDislikedBy' => \Yii::$app->user->identity->getId()]);
                $likeOrDislike->delete();

                //for program like counter
                if($present_status==0)
                    $program->noOfDislikes-=1;
                else
                    $program->noOLikes-=1;
                $program->save();
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
                if($model->save())
                {
                    return ['a'=>'1'];
                }
            }
            else
            {
                $model=WishList::findOne(['content'=>$id,'wishedBy'=>\Yii::$app->user->identity->getId()]);
                $model->delete();
                return ['a'=>'0'];
            }

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

    public function findSuggestions()
    {
        $contents=ContentRecord::find()->all();
        $scoresOfEachContent=[];
        $models=[];
        foreach($contents as $content)
        {
            $likeRecords=LikeDislikeContent::find()->where(['content'=>$content->id,'likeOrDislike'=>1]);
            $dislikeRecords=LikeDislikeContent::find()->where(['content'=>$content->id,'likeOrDislike'=>0]);
            $likes=$likeRecords->count();
            $dislikes=$dislikeRecords->count();
            $score=$likes-0.5*$dislikes;
            $scoresOfEachContent[$content->id]=$score;
        }
        arsort($scoresOfEachContent);
        foreach(array_keys($scoresOfEachContent) as $id)
        {
            $content=ContentRecord::findOne($id);
            array_push($models,$content);
        }
        return $models;
    }

    public function actionDownload($filename)
    {
            $path = Yii::getAlias('@webroot') . '/assets/Uploads';
            $file = $path . '/'.$filename;
            return $this->render('download',['file'=>$file]);

    }
}
