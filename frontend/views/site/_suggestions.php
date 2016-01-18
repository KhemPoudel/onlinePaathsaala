<?php //$this->beginBlock('suggestion_block');
use yii\helpers\Html;
?>
    <div class="card-panel bl-panel text-center hoverable" style="width: 190%;left:-28%;">
        <h5 class="black-text">Suggestions</h5>
        <hr>
        <ul class="nav nav-tabs tabs-5" style="
position: relative;
height: 48px;
background-color: #fff;
margin: 0 auto;
width: 100%;
white-space: nowrap;
border: none;
border-bottom: 1px solid #ddd;
padding-left: 0;
padding: 0
list-style: none;
box-shadow: 0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
            <li style="
    width: 33%;
    display: block;
    float: left;
    text-align: center;
    line-height: 48px;
    height: 48px;
    padding: 0;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: .8px;" class="active">
                <a data-toggle="tab" href="#home">Posts</a>
            </li>
            <li style="width: 33%;display: block;
float: left;
text-align: center;
line-height: 48px;
height: 48px;
padding: 0;
margin: 0;
text-transform: uppercase;
letter-spacing: .8px;
"><a data-toggle="tab" href="#programs">Programs</a></li>
            <li style="width: 33%;display: block;
float: left;
text-align: center;
line-height: 48px;
height: 48px;
padding: 0;
margin: 0;
text-transform: uppercase;
letter-spacing: .8px;"><a data-toggle="tab" href="#users">Users</a></li>
        </ul>

        <div class="tab-content pre-scrollable" >
            <div id="home" class="tab-pane fade in active">
                <?php
                $sugg_models=frontend\controllers\SiteController::suggestionForContentsOnTheBasisOfUserLikesAndDislikes();
                //print_r($sugg_models);
                if(empty($sugg_models))
                {
                    ?>
                    <span class="text-center" style="color: rgba(37, 140, 235, 0.17);"><h3>Nothing to Show</h3></span>
                    <?php
                }
                    ?>
                <div class="row">
                    <div class="horizontal-panel">
                        <div class="horizontal-listing">
                            <?php
                            foreach($sugg_models as $model)
                            {
                                ?>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <?php
                                            if($model->type=='img')
                                                $url='@web/assets/Uploads/'.$model->name;
                                            else
                                                $url='@web/images/'.$model->type.'_thumbnail.png';
                                            ?>
                                            <?= \yii\helpers\Html::img($url,['class'=>"img-responsive z-depth-2",'style'=>'width:107px;height:71px;'])?>
                                        </div>
                                        <div class="col-sm-8">
                                            <?php
                                            $link_user='<h5 class="title" style="font-size: 20px;
                                                                    margin-left: -61%;
                                                                    margin-top: 10%;">'.
                                                $model->name.
                                            '</h5>';

                                            echo Html::a($link_user,['content/viewsingle','id'=>$model->id]);
                                            ?>
                                            <ul class="list-inline item-details">
                                                <li><i class="fa fa-clock-o"> 05/10/2015</i></li>
                                                <li><a href="#"><i class="fa fa-comments-o"></i> <?=frontend\controllers\SiteController::getCommentsCount($model);?></a></li>
                                                <li><a href="#"><i class="fa fa-thumbs-o-up"> </i> <?=frontend\controllers\SiteController::getLikes($model);?></a></li>
                                                <li><a href="#"><i class="fa fa-thumbs-o-down"> </i> <?=frontend\controllers\SiteController::getDislikes($model);?></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php
                            }
                                ?>
                        </div>
                    </div>
                </div>
            </div>

            <div id="programs" class="tab-pane fade in">
                <?php
                    $sugg_models=frontend\controllers\SiteController::suggestionsForPrograms();
                    //print_r($sugg_models);
                    if(empty($sugg_models))
                    {
                        ?>
                        <span class="text-center" style="color: rgba(37, 140, 235, 0.17);"><h3>Nothing to Show</h3></span>
                        <?php
                    }
                        ?>
                <div class="row">
                    <div class="horizontal-panel">
                        <div class="horizontal-listing">
                            <?php
                            foreach($sugg_models as $model)
                            {
                                ?>
                                    <div class="row">
                                        <div>
                                            <div class="col-md-8">
                                                <?php
                                                $facultyRecord=\common\models\faculty\FacultyRecord::findOne($model->faculty_id);
                                                $faculty=$facultyRecord->name;
                                                $university=\common\models\university\UniversityRecord::findOne($facultyRecord->university_id)->name;
                                                $link_program='<h5 class="title" style="font-size: 20px;
                                                                    margin-left: -37%;
                                                                    margin-top: 10%;">'.$model->name.'</h5>';
                                                echo Html::a($link_program,['/course/index','program_id'=>$model->id,'faculty'=>$faculty,'university'=>$university]);
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                $follow_status='Unfollow';
                                                $btn_follow='<i class="fa fa-minus-circle"></i>';
                                                $follow_btn_class='';
                                                if(count(\common\models\FollowerProgram::find()->where(['user_id'=>\Yii::$app->user->identity->getId(),'program_id'=>$model->id])->all())==0) {
                                                    $follow_status = 'Follow';
                                                    $btn_follow='<i class="fa fa-user-plus"></i>';
                                                }
                                                ?>
                                                <button type="button" style="" class="btn btn-border-success btn-block btn-follow-program <?=$follow_btn_class?>" id="program-<?php echo $model->id?>" data-id="<?php echo $model->id?>" data-follow-status="<?php echo $follow_status?>">
                                                    <span id="span-program-<?php echo $model->id;?>"><?= $btn_follow?></span>
                                                </button>
                                            </div>

                                            <ul class="list-inline item-details">
                                                <li><i class="fa fa-clock-o"> 05/10/2015</i></li>
                                                <li><a href="#"><i class="fa fa-comments-o"></i> <?=$model->noOfFollowers;?></a></li>
                                                <li><a href="#"><i class="fa fa-thumbs-o-up"> </i> <?=$model->noOLikes;?></a></li>
                                                <li><a href="#"><i class="fa fa-thumbs-o-down"> </i> <?=$model->noOfDislikes;?></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php
                            }
                                ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="users" class="tab-pane fade in">
                <?php
                $sugg_models=frontend\controllers\SiteController::suggestionsForUsers();
                //print_r($sugg_models);
                if(empty($sugg_models))
                {
                    ?>
                    <span class="text-center" style="color: rgba(37, 140, 235, 0.17);"><h3>Nothing to Show</h3></span>
                    <?php
                }
                    ?>
                <div class="row">
                    <div class="horizontal-panel">
                        <div class="horizontal-listing">
                            <?php
                            foreach($sugg_models as $model)
                            {
                                ?>
                                    <div class="row">
                                        <div>
                                            <div class="col-md-8">
                                                <?php
                                                $link_program='<h5 class="title" style="font-size: 20px;
                                                                    margin-left: 0%;
                                                                    margin-top: 10%;">'.$model->username.'</h5>';
                                                echo Html::a($link_program,['user/profile/show','id'=>$model->id]);
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                $follow_status='Unfollow';
                                                $btn_follow='<i class="fa fa-minus-circle"></i>';
                                                $follow_btn_class='';
                                                if(count(\common\models\FollowerUsertoUser::find()->where(['followed_user_id'=>$model->id,'follower_user_id'=>\Yii::$app->user->identity->getId()])->all())==0) {
                                                    $follow_status = 'Follow';
                                                    $btn_follow='<i class="fa fa-user-plus"></i>';
                                                }
                                                ?>
                                                <button type="button" style="" class="btn btn-border-success btn-block btn-follow <?=$follow_btn_class?>" id="<?php echo $model->id?>" data-id="<?php echo $model->id?>" data-follow-status="<?php echo $follow_status?>">
                                                    <span id="span-<?php echo $model->id;?>"><?= $btn_follow?></span>
                                                </button>
                                            </div>
                                            <ul class="list-inline item-details">
                                                <li><i class="fa fa-clock-o"><?=Yii::t('user', '{0, date}', $model->created_at)?></i></li>
                                                <li>
                                                    <a href="#"><i class="fa fa-users">
                                                            <?=\common\models\FollowerUsertoUser::find()->where(['followed_user_id'=>$model->id])->count();?></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="fa fa-thumbs-o-up"> </i>
                                                        <?php
                                                        $contents=\common\models\content\ContentRecord::find()->where(['uploadedBy'=>$model->id])->all();
                                                        $contentsIds=\yii\helpers\ArrayHelper::getColumn($contents,'id');
                                                        $likeRecords=\common\models\LikeDislikeContent::find()->where(['content'=>$contentsIds,'likeOrDislike'=>1]);
                                                        echo $likeRecords->count();
                                                        ?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="fa fa-thumbs-o-down"> </i>
                                                        <?php
                                                        $dislikeRecords=\common\models\LikeDislikeContent::find()->where(['content'=>$contentsIds,'likeOrDislike'=>0]);
                                                        echo $dislikeRecords->count();
                                                        ?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php
                            }
                                ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php //$this->endBlock();?>
<?php
$js= <<<JS
        $('.btn-follow').on('click', function(e) {
            e.preventDefault();
            var id=$(this).attr('data-id');
            var follow_status=$(this).attr('data-follow-status');
            var data = {'followed_id':id,'follow_status':follow_status};
            alert(id);
            $.ajax({
                url:'/onlinePaathsaala/frontend/web/index.php/follow/addfollower',
                dataType:"json",
                type:'post',
                data: data,
                success: function(response) {
                    console.log(response);
                    if(response>=0)
                    {
                    if(response=='0')
                    {
                        $('#span-'+id).html('<i class="fa fa-minus-circle"></i>');
                        $('#'+id).attr('data-follow-status','Unfollow');
                    }

                    else{
                            $('#span-'+id).html('<i class="fa fa-user-plus"></i>');
                            $('#'+id).attr('data-follow-status','Follow');
                    }
                    }
                },
                error: function(xhr,status,err){
                console.log(status);
                console.log(err);
                }
            });
        });
        $('.btn-follow-program').on('click', function(e) {
            e.preventDefault();
            var id=$(this).attr('data-id');
            var follow_status=$(this).attr('data-follow-status');
            var data = {'program_id':id,'follow_status':follow_status};
            $.ajax({
                url:'/onlinePaathsaala/frontend/web/index.php/follow/removeoraddfollow',
                dataType:"json",
                type:'post',
                data: data,
                success: function(response) {
                    if(response>=0)
                    {
                       if(response=='0')
                    {
                        $('#span-program-'+id).html('<i class="fa fa-minus-circle"></i>');
                        $('#program-'+id).attr('data-follow-status','Unfollow');
                    }

                    else{
                            $('#span-program-'+id).html('<i class="fa fa-user-plus"></i>');
                            $('#program-'+id).attr('data-follow-status','Follow');
                    }
                    }
                },
                error: function(xhr,status,err){
                console.log(status);
                console.log(err);
                }
            });
        });
JS;
$this->registerJs($js);
?>