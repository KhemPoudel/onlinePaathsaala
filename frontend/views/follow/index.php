<?php
use yii\helpers\Html;
?>


    <!--1 Coulm horizontal listing-->
    <div class="card-panel horizontal-listing no-padding search-class">
        <div class="container-fluid">
            <h4 class="black-text"><?=$callerType;?><i class="material-icons"></i></h4>
            <h5 class="black-text"><?= '(',\dektrium\user\models\User::findOne($caller)->username,')'?></h5>
            <hr>
            <?php
            foreach($models as $model)
            {
                //$faculties=\common\models\faculty\FacultyRecord::find()->where(['university_id'=>$model->id]);
                ?>
                <div id="follow-div-<?=$model->id;?>">
                <a>
                    <div class="row hoverable">
                        <div class="col-sm-4">
                            <img src="http://mdbootstrap.com/images/reg/reg%20(54).jpg" class="img-responsive z-depth-2">
                        </div>
                        <div class="col-sm-8">
                            <?php
                            $link_user='<h5 class="title">'.$model->username.'</h5>';
                            echo Html::a($link_user,['/user/profile/show','id'=>$model->id]);
                            ?>
                            <?php
                            $follow_status='Unfollow';
                            $btn_follow='<i class="fa fa-minus-circle"></i>  Unfollow';
                            if(!$this->context->ifFollowerIsFollowedByCurrentUser($model->id)) {
                                $follow_status = 'Follow';
                                $btn_follow='<i class="fa fa-user-plus"></i>  Follow';
                            }
                            ?>
                            <button type="button" class="btn btn-border-success pull-right btn-follow-user" style="margin-top: -8%;" id="<?php echo $model->id?>" data-id="<?php echo $model->id?>" data-follow-status="<?php echo $follow_status?>">
                                <span id="span-<?php echo $model->id?>"><?= $btn_follow?></span>
                            </button>
                            <ul class="list-inline item-details">
                                <li><i class="fa fa-clock-o"><?=Yii::t('user', '{0, date}', $model->created_at);?></i></li>
                                <li><a>Courses </a></li>
                            </ul>

                            <p><?=$model->profile->bio;?></p>
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


<?php
$js = <<<JS
        // get the form id and set the event
        $('.btn-follow-user').on('click', function(e) {
            e.preventDefault();
            var id=$(this).attr('data-id');
            var follow_status=$(this).attr('data-follow-status');
            var status=$(this).attr('data-status');
            var data = {'followed_id':id,'follow_status':follow_status};
            alert(id);
            $.ajax({
                url:'addfollower',
                dataType:"json",
                type:'post',
                data: data,
                success: function(response) {
                    console.log(response);
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