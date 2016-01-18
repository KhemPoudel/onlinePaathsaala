<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\Collapse;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
$this->title = $model->name;
?>
<div class="row" style="padding-top: 10%;">
    <div class="col-md-12 blog-column">
        <div class="card-panel bl-panel text-center hoverable">
            <?php
            $link_user='<h4 class="black-text">'.$model->name.'<i class="material-icons"></i></h4>';
            echo Html::a($link_user,['content/viewsingle','id'=>$model->id]);
            ?>
            <h6>Added by
                <a href="#"><?= \dektrium\user\models\User::findOne(['id'=>$model->uploadedBy])->username?>
                </a>
                | 21.10.2015
            </h6>
            <hr>
            <div>

                <p class="text-center">
                    <?php
                    if($model->type=='video')
                    {
                        ?>
                        <video id="video" width="80%" height="80%" poster="" controls>
                            <source src="<?=Url::base()?>/assets/Uploads/<?= $model->name?>" type="video/<?=$model->ext?>">
                        </video>
                    <?php
                    }
                    elseif($model->type=='pdf')
                    {
                        ?>
                        <object data="<?= Url::base()?>/assets/Uploads/<?= $model->name?>" type="application/pdf" width="640" height="480">
                            alt : <a href="<?= Url::base()?> /assets/Uploads/<?= $model->name?>"><?=$model->name?></a>
                        </object>

                    <?php
                    }
                    else
                    {?>
                        <?= Html::img('@web/assets/Uploads/'.$model->name,['class'=>"img-responsive",'style'=>'margin:0 auto;'])?>
                        <?php
                    }?>
            </div>
<span class="label green">
                    <strong>
                        <?php
                            $topic=\common\models\topic\TopicRecord::findOne($model->topic_id);
                            $course=\common\models\course\CourseRecord::findOne($topic->course_id);
                            $program=\common\models\program\ProgramRecord::findOne($course->program_id);
                            $faculty=\common\models\faculty\FacultyRecord::findOne($program->faculty_id);
                            $univ=\common\models\university\UniversityRecord::findOne($faculty->university_id);
                            echo Html::a($topic->name,['content/index','topic_id'=>$topic->id,'university'=>$univ->name,'faculty'=>$faculty->name,'program'=>$program->name,'course'=>$course->name],['style'=>'color:black;']);
                        ?>
                    </strong>
                </span>
                <span class="label blue">
                    <strong>
                        <?php
                        echo Html::a($course->name,['topic/index','course_id'=>$course->id,'university'=>$univ->name,'faculty'=>$faculty->name,'program'=>$program->name],['style'=>'color:black;']);
                        ?>
                    </strong>
                </span>
                <span class="label blue-grey">
                    <strong>
                        <?php
                        echo Html::a($program->name,['course/index','program_id'=>$program->id,'university'=>$univ->name,'faculty'=>$faculty->name],['style'=>'color:black;']);
                        ?>
                    </strong>
                </span>
                <span class="label default-color">
                    <strong>
                        <?php
                        echo Html::a($faculty->name,['program/index','faculty_id'=>$faculty->id,'university'=>$univ->name],['style'=>'color:black;']);
                        ?>
                    </strong>
                </span>
                <span class="label orange">
                    <strong>
                        <?php
                        echo Html::a($univ->name,['faculty/index','university_id'=>$univ->id],['style'=>'color:black;']);
                        ?>
                    </strong>
                </span>

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
                        $('#add-to-wish-list-'+id).html('<i class="fa fa-minus"></i>' +
                         'Remove From WishList');
                        $('#'+id).attr('data-status','0');
                    }
                    else{
                        $('#add-to-wish-list-'+id).html('<i class="fa fa-plus"></i>' +
                         'Add to WishList');
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

