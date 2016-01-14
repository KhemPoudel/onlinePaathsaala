<div class="panel panel-primary">
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
<
<?php
$js = <<<JS
        // get the form id and set the event
        $('.btn-follow').on('click', function(e) {
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
                            $('#span-'+id).text('Unfollow');
                            $('#'+id).attr('data-follow-status','Unfollow');
                        }

                        else{
                                $('#span-'+id).text('Follow');
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