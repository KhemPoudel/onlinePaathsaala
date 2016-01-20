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
                        'actions' => ['signup','error'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index','about','contact','update','addcomment','addwish','download','notifications'],
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
        $arr=$this->suggestionForContentsOnTheBasisOfUserLikesAndDislikes();
        if(empty($models))
        {
            $models=$this->findSuggestions();
        }
        return $this->render('index',['models'=>$models,'pages'=>$pages,'arr'=>$arr]);
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

    public function getCommentsCount($model)
    {
        $comments=CommentsContent::find()->where(['commentedOn'=>$model->id]);
        return $comments->count();
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
                $profile=\dektrium\user\models\Profile::findOne(['user_id'=>$model->commentedBy]);
                return [
                    'image'=>$profile->name,
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

    public function suggestionForContentsOnTheBasisOfUserLikesAndDislikes()
    {
        $current_user=\Yii::$app->user->identity->getId();
        $allModels=ContentRecord::find()->all();
        $allModelsIds=ArrayHelper::getColumn($allModels,'id');
        //$modelsIds=ArrayHelper::getColumn($models,'id');
        $modelsToBeComputedIds=array_diff($allModelsIds,[]);//$modelsIds);
        //$l1 is all Contents Liked By Current User
        $likedByCurrentUser=LikeDislikeContent::find()->where(['likeOrDislike'=>1,'likedOrDislikedBy'=>$current_user])->all();
        $l1=ArrayHelper::getColumn($likedByCurrentUser,'content');
        //$d1 is all Contents Disliked By Current User
        $dislikedByCurrentUser=LikeDislikeContent::find()->where(['likeOrDislike'=>0,'likedOrDislikedBy'=>$current_user])->all();
        $d1=ArrayHelper::getColumn($dislikedByCurrentUser,'content');
        $arrayOfProbability=[];
        foreach($modelsToBeComputedIds as $id)
        {
            $likedRecords=LikeDislikeContent::find()->where(['likeOrDislike'=>1,'content'=>$id])->all();
            $likerUsersIds=ArrayHelper::getColumn($likedRecords,'likedOrDislikedBy');//all users liking the content
            $dislikedRecords=LikeDislikeContent::find()->where(['likeOrDislike'=>0,'content'=>$id])->all();
            $dislikerUsersIds=ArrayHelper::getColumn($dislikedRecords,'likedOrDislikedBy');//all users disliking the content
            //zl is sum of similarities between likers and current user
            $zl=0;
            foreach($likerUsersIds as $likerUsersId)
            {
                //$l2 is all Contents Liked By This User
                $likedByUser=LikeDislikeContent::find()->where(['likeOrDislike'=>1,'likedOrDislikedBy'=>$likerUsersId])->all();
                $l2=ArrayHelper::getColumn($likedByUser,'content');
                //$d2 is all Contents Disliked By This User
                $dislikedByUser=LikeDislikeContent::find()->where(['likeOrDislike'=>0,'likedOrDislikedBy'=>$likerUsersId])->all();
                $d2=ArrayHelper::getColumn($dislikedByUser,'content');
                $l1Intersectl2=count(array_intersect($l1,$l2));
                $d1Intersectd2=count(array_intersect($d1,$d2));
                $l1Intersectd2=count(array_intersect($l1,$d2));
                $l2Intersectd1=count(array_intersect($l2,$d1));
                $l1Ul2Ud1Ud2=count(array_unique(array_merge($l1,$l2,$d1,$d2)));

                //$s is similarity index Between Current User And This User
                $s=($l1Intersectl2+$d1Intersectd2-$l1Intersectd2-$l2Intersectd1)/$l1Ul2Ud1Ud2;
                $zl+=$s;
            }
            //zd is sum of similarities between dislikers and current user
            $zd=0;
            foreach($dislikerUsersIds as $dislikerUsersId)
            {
                //$l2 is all Contents Liked By This User
                $likedByUser=LikeDislikeContent::find()->where(['likeOrDislike'=>1,'likedOrDislikedBy'=>$dislikerUsersId])->all();
                $l2=ArrayHelper::getColumn($likedByUser,'content');
                //$d2 is all Contents Disliked By This User
                $dislikedByUser=LikeDislikeContent::find()->where(['likeOrDislike'=>0,'likedOrDislikedBy'=>$dislikerUsersId])->all();
                $d2=ArrayHelper::getColumn($dislikedByUser,'content');

                $l1Intersectl2=count(array_intersect($l1,$l2));
                $d1Intersectd2=count(array_intersect($d1,$d2));
                $l1Intersectd2=count(array_intersect($l1,$d2));
                $l2Intersectd1=count(array_intersect($l2,$d1));
                $l1Ul2Ud1Ud2=count(array_unique(array_merge($l1,$l2,$d1,$d2)));

                //$s is similarity index Between Current User And This User
                $s=($l1Intersectl2+$d1Intersectd2-$l1Intersectd2-$l2Intersectd1)/$l1Ul2Ud1Ud2;
                $zd+=$s;
            }
            $totalCount=count($likerUsersIds)+count($dislikerUsersIds);
            if($totalCount==0)
                $p=-100;
            else
                $p=($zl-$zd)/$totalCount;
            $arrayOfProbability[$id]=$p;
        }
        arsort($arrayOfProbability);
        $models=[];
        foreach(array_keys($arrayOfProbability) as $id)
        {
            $content=ContentRecord::findOne($id);
            array_push($models,$content);
        }
        return $models;
    }

    public function suggestionsForPrograms()
    {
        $current_user=\Yii::$app->user->identity->getId();
        $programsFollowedByCurrentUser=FollowerProgram::find()->where(['user_id'=>$current_user])->all();
        if(empty($programsFollowedByCurrentUser))
        {
            $programs=ProgramRecord::find()->all();
            $scoresOfEachProgram=[];
            $models=[];
            foreach($programs as $program)
            {
                $follows=$program->noOfFollowers;
                $likes=$program->noOLikes;
                $dislikes=$program->noOfDislikes;
                $score=2*$follows+$likes-0.5*$dislikes;
                $scoresOfEachProgram[$program->id]=$score;
            }
            arsort($scoresOfEachProgram);
            foreach(array_keys($scoresOfEachProgram) as $id)
            {
                $program=ProgramRecord::findOne($id);
                array_push($models,$program);
            }
            return $models;
        }
        else
        {
            $targetPrograms=[];
            foreach($programsFollowedByCurrentUser as $followedProgram)
            {
                $allFollowersOfFollowedProgram=FollowerProgram::find()->where(['program_id'=>$followedProgram->program_id])->all();
                foreach($allFollowersOfFollowedProgram as $singleFollowerOfFollowee)
                {
                    $followeesOfFollowerOfFolloweesOfCurrentUser=FollowerProgram::find()->where(['user_id'=>$singleFollowerOfFollowee->user_id])->all();
                    foreach($followeesOfFollowerOfFolloweesOfCurrentUser as $targetProgram)
                    {
                        array_push($targetPrograms,$targetProgram);
                    }
                }

            }
            $followingProgramsIds=ArrayHelper::getColumn($programsFollowedByCurrentUser,'program_id');
            $targetProgramsIds=ArrayHelper::getColumn($targetPrograms,'program_id');
            $resultProgramsIds=array_diff($targetProgramsIds,$followingProgramsIds);
            $countOfPrograms=array_count_values($resultProgramsIds);
            $scoresOfEachProgram=[];
            foreach(array_unique($resultProgramsIds) as $programId)
            {
                $followersOfProgram=FollowerProgram::find()->where(['program_id'=>$programId])->all();
                $firstWeight=count($followersOfProgram);
                $secondWeight=$countOfPrograms[$programId];
                $scoresOfEachProgram[$programId]=($firstWeight+$secondWeight)/2;
            }
            $models=[];
            arsort($scoresOfEachProgram);
            foreach(array_keys($scoresOfEachProgram) as $id)
            {
                $program=ProgramRecord::findOne($id);
                array_push($models,$program);
            }
            return $models;
        }
    }

    public function suggestionsForUsers()
    {
        $current_user=\Yii::$app->user->identity->getId();
        $followees=FollowerUsertoUser::find()->where(['follower_user_id'=>$current_user])->all();
        if(empty($followees))
        {
            $users=User::find()->all();
            $scoresOfEachUser=[];
            $models=[];
            foreach($users as $user)
            {
                $followRecords=FollowerUsertoUser::find()->where(['followed_user_id'=>$user->id]);
                $follows=$followRecords->count();
                $contents=ContentRecord::find()->where(['uploadedBy'=>$user->id])->all();
                $contentsIds=ArrayHelper::getColumn($contents,'id');
                $likeRecords=LikeDislikeContent::find()->where(['content'=>$contentsIds,'likeOrDislike'=>1]);
                $dislikeRecords=LikeDislikeContent::find()->where(['content'=>$contentsIds,'likeOrDislike'=>0]);
                $score=2*$follows+$likeRecords->count()-0.5*$dislikeRecords->count();
                $scoresOfEachUser[$user->id]=$score;
            }
            arsort($scoresOfEachUser);
            foreach(array_keys($scoresOfEachUser) as $id)
            {
                $user=User::findOne($id);
                array_push($models,$user);
            }
            return $models;
        }
        else {
            $targetUsers = [];
            foreach ($followees as $followee) {
                $followersOfFollowee = FollowerUsertoUser::find()->where(['followed_user_id' => $followee->followed_user_id])->all();
                foreach ($followersOfFollowee as $singleFollowerOfFollowee) {
                    $followeesOfFollowerOfFollowees = FollowerUsertoUser::find()->where(['follower_user_id' => $singleFollowerOfFollowee->follower_user_id])->all();
                    foreach ($followeesOfFollowerOfFollowees as $targetUser) {
                        array_push($targetUsers, $targetUser);
                    }
                }

            }
            $followeesIds = ArrayHelper::getColumn($followees, 'followed_user_id');
            $targetUsersIds = ArrayHelper::getColumn($targetUsers, 'followed_user_id');
            $resultUsersIds = array_diff($targetUsersIds, $followeesIds);
            $countOfUsers = array_count_values($resultUsersIds);
            $scoresOfEachUser = [];
            foreach (array_unique($resultUsersIds) as $userId) {
                $followersOfUser = FollowerUsertoUser::find()->where(['followed_user_id' => $userId])->all();
                $followeesOfUser = FollowerUsertoUser::find()->where(['follower_user_id' => $userId])->all();
                $followeesIdsOfUser=ArrayHelper::getColumn($followeesOfUser,'followed_user_id');
                if(count($followeesOfUser)==0)
                {
                    $firstWeight=count($followersOfUser);
                }
                else
                    $firstWeight = count($followersOfUser)/count($followeesOfUser);
                $secondWeight = $countOfUsers[$userId];
                $thirdWeight=array_intersect($followeesIdsOfUser,$followeesIds);
                $scoresOfEachUser[$userId] = ($firstWeight+$secondWeight+count($thirdWeight))/3;
            }
            $models=[];
            arsort($scoresOfEachUser);
            foreach (array_keys($scoresOfEachUser) as $id) {
                $user = User::findOne($id);
                array_push($models, $user);
            }
            return $models;
        }
    }

    public function actionNotifications()
    {
        $user=Yii::$app->user->identity->getId();
        $userRecord=User::findOne($user);
        if($userRecord->role==10)
        {
            $models=ContentRecord::find()->where(['uploadedBy'=>$user])->all();
            //$models=$modelsUsers->filterWhere(['flag'=>1])->orWhere(['flag'=>-1]);
        }
        else
            $models=[];
        return $this->render('/notifications/index', [
        'models' => $models,
    ]);
    }
}
