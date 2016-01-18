<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\Collapse;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
$this->title = 'Timeline';
?>
<div class="col-md-12 blog-column" style="margin-top: 5.8%;">
    <div class="card-panel bl-panel text-center hoverable">
        <?php
            echo $this->render('_upload');
        ?>
        </div>
    </div>
    <?php
    foreach($models as $model)
    {
    ?>
    <div>
        <div class="col-md-12 blog-column" style="margin-top: 5.8%;">
            <div class="card-panel bl-panel text-center hoverable">
                <?php
                $link_user='<h5 class="black-text">'.$model->name.'<i class="material-icons"></i></h5>';
                echo Html::a($link_user,['content/viewsingle','id'=>$model->id]);
                ?>
                <h6>Added by
                    <a href="#"><?= \dektrium\user\models\User::findOne(['id'=>$model->uploadedBy])->username?>
                    </a>
                    | <?=Yii::t('user', '{0, date}', $model->posted_at);?>
                </h6>
                <hr>
                <div class="" style="padding-left:">


                        <?php
                        if($model->type=='video')
                        {
                            ?>
                            <p class="text-center">
                                <video id="video" width="80%" height="80%" poster="" controls>
                                    <source src="<?=Url::base()?>/assets/Uploads/<?= $model->address?>" type="video/<?=$model->ext?>">
                                </video>
                            </p>
                        <?php
                        }
                        elseif($model->type=='pdf') {
                            ?>
                            <p class="text-center">
                                <object data="<?= Url::base() ?>/assets/Uploads/<?= $model->address ?>" type="application/pdf" width="100%" height="360">
                                    alt : <a href="<?= Url::base() ?> /assets/Uploads/<?= $model->address ?>"><?= $model->name ?></a>
                                </object>
                            </p>

                        <?php
                        }

                        else
                        {
                            ?>
                            <p class="" style="width: 100%;height: 100%;">
                                <?= Html::img('@web/assets/Uploads/'.$model->address,['class'=>"img-responsive",'style'=>'margin:0 auto;'])?>
                            </p>

                         <?php
                        }?>
                </div>

                <span class="label green">
                    <strong>
                    <?php
                        $topic=\common\models\topic\TopicRecord::findOne($model->topic_id);
                        echo $topic->name;
                    ?>
                    </strong>
                </span>
                <span class="label blue">
                    <strong>
                        <?php
                            $course=\common\models\course\CourseRecord::findOne($topic->course_id);
                            echo $course->name;
                        ?>
                    </strong>
                </span>
                <span class="label blue-grey">
                    <strong>
                        <?php
                            $program=\common\models\program\ProgramRecord::findOne($course->program_id);
                            echo $program->name;
                        ?>
                    </strong>
                </span>
                <span class="label default-color">
                    <strong>
                        <?php
                            $faculty=\common\models\faculty\FacultyRecord::findOne($program->faculty_id);
                            echo $faculty->name;
                        ?>
                    </strong>
                </span>
                <span class="label orange">
                    <strong>
                        <?php
                            $univ=\common\models\university\UniversityRecord::findOne($faculty->university_id);
                            echo $univ->name;
                        ?>
                    </strong>
                </span>

                <div id="likedislikediv">',
                    <?php echo $this->render('_likedislike', array('model'=>$model)); ?>
                </div>
                </p>

            </div>
        </div>
    </div>
        <div class="row" style="width: 87%;margin-left: 6.5%;">
            <?php
            echo Collapse::widget([
                'items' => [
                    // equivalent to the above
                    [
                        'label' =>'View Discussions',
                        'content' => $this->context->getComments($model),
                        // open its content by default
                        'contentOptions' => ['class' => 'out'],
                    ],
                ]
            ]);
            ?>
        </div>
        <?php
    }
        ?>


<?php echo LinkPager::widget([
'pagination' => $pages,
]);
?>
<?php //$this->render('_suggestions');?>
<?php
$js = <<<JS
        // get the form id and set the event
        $('.btn-add-to-wishlist').on('click', function(e) {
            e.preventDefault();
            var id=$(this).attr('data-id');
            var status=$(this).attr('data-status');
            var data = {'id':id,'status':status};
            //console.log(data);
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

