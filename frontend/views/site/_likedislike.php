<?php
use yii\helpers\Url;

$current_status=$this->context->ifWished($model->id);
if($current_status==1){
    $icon_class="fa fa-plus";
    $btn_text='Add to WishList';
}

else
{
    $icon_class="fa fa-minus";
    $btn_text='Remove From WishList';
}

?>
<div id="like-section-<?php echo $model->id?>">
    <form>
        <div class="input-group">
            <div class="input-group-btn">
                <?php $like_status=$this->context->IflikedByUser($model);
                    if($like_status==1){
                        $btn_class_for_like='btn-border-primary';
                        $btn_class_for_dislike='btn-border-default';
                    }
                    else {
                        if ($like_status == 0) {
                            $btn_class_for_dislike = 'btn-border-danger';
                            $btn_class_for_like = 'btn-border-default';
                        } else {
                            $btn_class_for_like = 'btn-border-default';
                            $btn_class_for_dislike = 'btn-border-default';
                        }
                    }
                ?>
                <button class="btn btn-mini btn-like-dislike <?php echo $btn_class_for_dislike;?>" id="dislike-btn-<?php echo $model->id;?>" data-like-status="<?php echo $like_status?>" data-present-status="0" data-id="<?php echo $model->id?>">
                    <span id="no-of-dislikes-<?php echo $model->id;?>"><?php echo $this->context->getDislikes($model);?></span>
                    <i class="fa fa-thumbs-down"></i>
                </button>
                <button class="btn btn-mini btn-like-dislike <?php echo $btn_class_for_like;?>" id="like-btn-<?php echo $model->id;?>" data-like-status="<?php echo $like_status?>" data-present-status="1" data-id="<?php echo $model->id?>">
                    <span id="no-of-likes-<?php echo $model->id;?>"><?php echo $this->context->getLikes($model);?></span>
                    <i class="fa fa-thumbs-up"></i>
                </button>
                <button type="button" class="btn btn-border-default btn-mini btn-add-to-wishlist" id="<?=$model->id?>" data-id="<?= $model->id?>" data-status="<?=$current_status?>">
                    <span id="add-to-wish-list-<?=$model->id?>">
                        <i class="<?=$icon_class?>"></i>
                        <?= $btn_text?>
                    </span>
                </button>
                <button type="button" class="btn btn-mini btn-border-primary">
                    <?= \yii\helpers\Html::a('<i class="fa fa-download"></i>',['download','filename'=>$model->address],['target'=>'_blank']);?>
                </button>

            </div>
        </div>
    </form>
</div>

<?php
$js = <<<JS
        // get the form id and set the event
        $('.btn-like-dislike').on('click', function(e) {
            e.preventDefault();
            var like_status=$(this).attr('data-like-status');
            var present_status=$(this).attr('data-present-status');
            var id=$(this).attr('data-id');
            var data = {'like_status' :like_status,'present_status' :present_status,'id':id};
            console.log(data);
            $.ajax({
                url:'/onlinePaathsaala/frontend/web/index.php/site/update',
                dataType:"json",
                type:'post',
                data: data,
                success: function(response) {
                if(response.new_like_status==1){
                        btn_class_for_like='btn-border-primary';
                        btn_class_for_dislike='btn-border-default';
                    }
                    else {
                        if (response.new_like_status == 0) {
                            btn_class_for_dislike = 'btn-border-danger';
                            btn_class_for_like = 'btn-border-default';
                        } else {
                            btn_class_for_like = 'btn-border-default';
                            btn_class_for_dislike = 'btn-border-default';
                        }
                    }
                    $('#no-of-likes-'+response.new_id).html('<span id="no-of-likes-'+response.new_id+'">'+
                    response.likes);
                    $('#no-of-dislikes-'+response.new_id).html('<span id="no-of-dislikes-'+response.new_id+'">'+
                    response.dislikes);
                    $('#like-btn-'+response.new_id).attr('data-like-status',response.new_like_status);
                    $('#dislike-btn-'+response.new_id).attr('data-like-status',response.new_like_status);
                    $('#like-btn-'+response.new_id).attr('class','btn btn-like-dislike '+ btn_class_for_like);
                    $('#dislike-btn-'+response.new_id).attr('class','btn btn-like-dislike '+ btn_class_for_dislike);
                },
                error: function(xhr,status,err){
                console.log(status);
                console.log(err);
                }
            });
        });
;
JS;
$this->registerJs($js);
?>