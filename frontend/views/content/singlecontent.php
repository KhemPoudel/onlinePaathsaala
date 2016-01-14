<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\Collapse;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
$this->title = 'Timeline';
?>
<div class="row">
    <div class="col-md-12 blog-column">
        <div class="card-panel bl-panel text-center hoverable">
            <?php
            $link_user='<h3 class="black-text">'.$model->name.'<i class="material-icons"></i></h3>';
            echo Html::a($link_user,['content/viewsingle','id'=>$model->id]);
            ?>
            <h5>Added by
                <a href="#"><?= \dektrium\user\models\User::findOne(['id'=>$model->uploadedBy])->username?>
                </a>
                | 21.10.2015
            </h5>
            <hr>
            <div>

                <p class="text-center">
                    <?php
                    if($model->type=='video')
                    {
                        ?>
                        <video id="video" width="640" height="480" poster="" controls>
                            <source src="<?=Url::base()?>/assets/Uploads/<?= $model->name?>" type="video/<?=$model->ext?>">
                        </video>
                    <?php
                    }
                    else
                    {
                        ?>
                        <object data="<?= Url::base()?>/assets/Uploads/<?= $model->name?>" type="application/pdf" width="640" height="480">
                            alt : <a href="<?= Url::base()?> /assets/Uploads/<?= $model->name?>"><?=$model->name?></a>
                        </object>

                    <?php
                    }?>
            </div>


            <div id="likedislikediv">',
                <?php echo $this->render('_likedislike', array('model'=>$model)); ?>
            </div>
            </p>

        </div>
    </div>
<?php
    echo '<div>',$this->context->getComments($model),'</div>';
?>
</div>


<!--<span>
    <button class="btn btn-default pull-right btn-add-to-wishlist" style="margin-top: -4.5%" id="',$model->id,'" data-id="',$model->id,'" data-status="',$current_status,'">
        <span id="add-to-wish-list-',$model->id,'">',
        $btn_text,
        '</span>
    </button>
</span>-->


<?php
$js = <<<JS
        // get the form id and set the event
        $('.btn-add-to-wishlist').on('click', function(e) {
            e.preventDefault();
            var id=$(this).attr('data-id');
            var status=$(this).attr('data-status');
            var data = {'id':id,'status':status};
            //alert(status);
            $.ajax({
                url:'addwish',
                dataType:"json",
                type:'post',
                data: data,
                success: function(response) {
                console.log(response);
                    if(status=='1')
                    {
                        $('#add-to-wish-list-'+id).text('Remove From WishList');
                        $('#'+id).attr('data-status','0');
                    }
                    else{
                        $('#add-to-wish-list-'+id).text('Add to WishList');
                        $('#'+id).attr('data-status','1');
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

