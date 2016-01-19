<?php
use yii\helpers\Html;
?>
<div id="post-div-<?php echo $id;?>" class="pre-scrollable">
    <div class="card-panel horizontal-listing comments-section">
        <?php
            foreach($models as $model)
            {?>
                <div class="row hoverable">
                    <div class="col-sm-2">
                        <?php
                        //$user=\dektrium\user\models\User::findOne($model->commentedBy);
                        $profile=\dektrium\user\models\Profile::findOne(['user_id'=>$model->commentedBy]);
                        ?>
                        <?=Html::img('@web/images/'.$profile->name,['class'=>'z-depth-1','style'=>'width:132%;height:103px;'])?>
                    </div>
                    <div class="col-sm-10" style="padding-left: 32px;">
                        <a href="#">
                            <h6 class="title"><?php echo \dektrium\user\models\User::findOne(['id'=>$model->commentedBy])->username;?>
                            </h6>
                        </a>
                        <i class="fa fa-clock-o"><?=Yii::t('user', '{0, date}', $model->commentedAt)?></i>
                        <p>
                            <?php echo $model->comment;?>
                        </p>
                    </div>
                </div>
            <?php }?>
    <div class="card-panel reply-section hoverable">
        <div class="row">
            <h6 class="text-center">Leave a comment</h6>
            <hr>
            <form class="col-md-12">
            <div class="input-field">
                <!--<i class="material-icons prefix">mode_edit</i>-->
                <textarea id="comment-on-<?php echo $id;?>" class="materialize-textarea"></textarea>
                <label for="reply-text">Your message</label>
            </div>
            </form>
            <div class="text-center">
                <button type="button" class="btn btn-primary waves-effect waves-light btn-add-comment" data-commented-on="<?php echo $id;?>">Submit</button>
            </div>
            </div>
        </div>
        </div>
</div>
<?php
$js = <<<JS
        // get the form id and set the event
        $('.btn-add-comment').on('click', function(e) {
            e.preventDefault();
            var commentedOn=$(this).attr('data-commented-on');
            var comment=$('#comment-on-'+commentedOn).val();
            var data = {'commentedOn' :commentedOn,'comment' :comment};
            alert(commentedOn);
            $.ajax({
                url:'/onlinePaathsaala/frontend/web/index.php/site/addcomment',
                dataType:"json",
                type:'post',
                data: data,
                success: function(response) {
                alert(response.commentedOn);
                    $('#post-div-'+response.commentedOn).prepend(
                    '<div class="row hoverable">'+
                    '<div class="col-sm-2">'+
                        '<img src="/onlinePaathsaala/frontend/web/images/'+response.image+'" class="z-depth-1" style="width:94%;height:90px;">'+
                    '</div>'+
                    '<div class="col-sm-10">'+
                        '<a href="#">'+
                            '<h6 class="title">'+response.commentedBy+
                            '</h6>'+
                        '</a>'+
                        '<i class="fa fa-clock-o">'+response.commentedAt+'</i>'+
                        '<p>'+
                            response.comment+
                        '</p>'+
                    '</div>'+
                '</div>'
                    );
                    $('#comment-on-'+commentedOn).val('');

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

