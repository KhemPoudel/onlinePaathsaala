<?php
use yii\helpers\Html;
?>


    <!--1 Coulm horizontal listing-->
    <div class="card-panel horizontal-listing no-padding search-class">
        <div class="container-fluid">
            <h4 class="black-text">Programs Followed<i class="material-icons"></i></h4>
            <h5 class="black-text"><?= '(',\dektrium\user\models\User::findOne($caller)->username,')'?></h5>
            <hr>
            <?php
            foreach($models as $model)
            {
                $courses=\common\models\course\CourseRecord::find()->where(['program_id'=>$model->id]);
                //$faculties=\common\models\faculty\FacultyRecord::find()->where(['university_id'=>$model->id]);
                ?>
                <div id="program-div-<?=$model->id;?>">
                    <a>
                        <div class="row hoverable">
                            <div class="col-sm-4">
                                <img src="http://mdbootstrap.com/images/reg/reg%20(54).jpg" class="img-responsive z-depth-2">
                            </div>
                            <div class="col-sm-8">
                                <?php
                                $link_program='<h5 class="title">'.$model->name.'</h5>';
                                echo Html::a($link_program,['/program/show','id'=>$model->id]);
                                ?>
                                <?php
                                $follow_status='Unfollow';
                                $btn_follow='<i class="fa fa-minus-circle"></i>  Unfollow';
                                if(!$this->context->ifFollowerIsFollowedByCurrentUser($model->id)) {
                                    $follow_status = 'Follow';
                                    $btn_follow='<i class="fa fa-user-plus"></i>  Follow';
                                }
                                ?>
                                <button type="button" class="btn btn-border-success pull-right btn-follow-program" style="margin-top: -8%;" id="<?php echo $model->id?>" data-id="<?php echo $model->id?>" data-follow-status="<?php echo $follow_status?>">
                                    <span id="span-<?php echo $model->id?>"><?= $btn_follow?></span>
                                </button>
                                <ul class="list-inline item-details">
                                    <li><i class="fa fa-clock-o"></i></li>
                                    <li><a>Courses <?=$courses->count()?></a></li>
                                    <li><a>Followers <?=$model->noOfFollowers?></a></li>
                                </ul>

                                <p></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <!--/.1 Column horizontal listing-->

    <!--<div class="panel panel-primary">
        <div class="panel-heading">
            <span><strong>Programs Followed </strong><?= '(',\dektrium\user\models\User::findOne($caller)->username,')'?></span>
        </div>
        <div class="panel-body">
            <div class="list-group">
            <div class="text-center">
                <?php
                if(empty($models))
                    echo '<h4>No Programs Followed</h4>';
                ?>
            </div>
            <?php
            foreach ($models as $model)
            {
                ?>
                <div id="program-div-<?=$model->id?>">
                    <?php
                    $link='<h4 style="color: #222222;" class="list-group-item-heading">'.$model->name.'</h4>';
                    ?>
                    <div class="list-group-item">
                        <?= \yii\bootstrap\Html::a($link,['/program/show','id'=>$model->id]);?>
                        <?php
                        $follow_status='Unfollow';
                        if(!$this->context->ifProgramIsFollowedByCurrentUser($model->id))
                            $follow_status='Follow';
                        ?>
                        <button type="button" class="btn btn-default pull-right btn-follow" style="margin-top: -1.5%;" id="<?= $model->id?>" data-id="<?= $model->id?>" data-follow-status="<?php echo $follow_status?>">
                        <span id="span-<?php echo $model->id?>">
                            <?= $follow_status?>
                        </span>
                        </button>
                        <p class="list-group-item-text"><?php $faculty=\common\models\faculty\FacultyRecord::findOne(['id'=>$model->faculty_id]); ?>
                            <?php echo '<span><strong>Faculty:</strong>',$faculty->name ,'</span>'?>
                            <br>
                            <?php echo '<span><strong>Level:</strong>',$faculty->level ,'</span>'?>
                            <br>
                            <?= '<span><strong>University:</strong>',\common\models\university\UniversityRecord::findOne(['id'=>$faculty->id])->name,'</span>' ?>
                        </p>
                    </div>
                </div>

            <?php
            }
            ?>
        </div>
        </div>
    </div>
    -->
<?php
$js = <<<JS
        // get the form id and set the event
        $('.btn-follow-program').on('click', function(e) {
            e.preventDefault();
            var id=$(this).attr('data-id');
            var follow_status=$(this).attr('data-follow-status');
            var data = {'program_id':id,'follow_status':follow_status};
            $.ajax({
                url:'removeoraddfollow',
                dataType:"json",
                type:'post',
                data: data,
                success: function(response) {
                    if(response>=0)
                    {
                        if(response=='0')
                    {
                        $('#span-'+id).html('<i class="fa fa-minus-circle"></i> Unfollow');
                        $('#'+id).attr('data-follow-status','Unfollow');
                    }

                    else{
                            $('#span-'+id).html('<i class="fa fa-user-plus"></i> Follow');
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

JS;
$this->registerJs($js);
?>