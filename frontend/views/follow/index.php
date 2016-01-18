<div class="panel panel-primary">
    <div class="panel-heading">
        <span><strong><?= $callerType;?>  </strong><?= '(',\dektrium\user\models\User::findOne($caller)->username,')'?></span>
    </div>
    <div class="panel-body">
        <div class="list-group">
            <div class="text-center">
                <?php
                if(empty($models))
                    echo '<h4>Nothing to Show</h4>';
                ?>
            </div>
            <?php
            foreach ($models as $model)
            {
                ?>
                <div id="follow-div-<?php echo $model->id;?>">
                    <?php
                    $link='<h4 class="list-group-item-heading">'.$model->username.'</h4>';
                    ?>
                    <div class="list-group-item">
                        <?= \yii\bootstrap\Html::a($link,['/user/profile/show','id'=>$model->id]);?>
                        <?php
                        $follow_status='Unfollow';
                        $btn_follow='<i class="fa fa-minus-circle"></i>  Unfollow';
                        if(!$this->context->ifFollowerIsFollowedByCurrentUser($model->id)) {
                            $follow_status = 'Follow';
                            $btn_follow='<i class="fa fa-user-plus"></i>  Follow';
                        }
                        ?>
                        <button type="button" class="btn btn-success pull-right btn-follow" style="margin-top: -2%;" id="<?php echo $model->id?>" data-id="<?php echo $model->id?>" data-status="<?php echo $caller;?>" data-follow-status="<?php echo $follow_status?>">
                            <span id="span-<?php echo $model->id?>"><?= $btn_follow?></span>
                        </button>
                        <p class="list-group-item-text"><?= Yii::t('user', 'Joined on {0, date}', $model->created_at) ?></p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<?php
$js = <<<JS
        // get the form id and set the event
        $('.btn-follow').on('click', function(e) {
            e.preventDefault();
            var id=$(this).attr('data-id');
            var follow_status=$(this).attr('data-follow-status');
            var status=$(this).attr('data-status');
            var data = {'followed_id':id,'follow_status':follow_status};
            alert(status);
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