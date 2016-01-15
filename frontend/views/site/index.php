<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\Collapse;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
$this->title = 'Timeline';
print_r($arr);
?>

    <?php
    foreach($models as $model)
    {
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
                <div class="col-md-6">

                    <p class="text-left">
                        <?php
                        if($model->type=='video')
                        {
                            ?>
                            <video id="video" width="320" height="240" poster="" controls>
                                <source src="<?=Url::base()?>/assets/Uploads/<?= $model->name?>" type="video/<?=$model->ext?>">
                            </video>
                        <?php
                        }
                        else
                        {
                            ?>
                            <object data="<?= Url::base()?>/assets/Uploads/<?= $model->name?>" type="application/pdf" width="320" height="240">
                                alt : <a href="<?= Url::base()?> /assets/Uploads/<?= $model->name?>"><?=$model->name?></a>
                            </object>

                        <?php
                        }?>
                </div>

                <div class="col-md-6 model-content model-cart">

                    <ul class="collection text-left">

                        <li class="collection-item">
                            <div>
                                <p>
                                    <span class="label green"><strong>Topic</strong></span>
                                    <?php
                                    $topic=\common\models\topic\TopicRecord::findOne($model->topic_id);
                                    echo $topic->name;
                                    ?>
                                    <a href="#!" class="secondary-content"><i class="material-icons"></i></a></p>
                            </div>
                        </li>
                        <li class="collection-item">
                            <div><p><span class="label green"><strong>Course</strong></span>
                                    <span class="quantity"></span>
                                    <?php
                                    $course=\common\models\course\CourseRecord::findOne($topic->course_id);
                                    echo $course->name;
                                    ?>
                                    <a href="#!" class="secondary-content"><i class="material-icons"></i></a></p></div>
                        </li>
                        <li class="collection-item">
                            <div><p>
                                    <span class="label green"><strong>Program</strong></span>
                                    <span class="quantity"></span>
                                    <?php
                                    $program=\common\models\program\ProgramRecord::findOne($course->program_id);
                                    echo $program->name;
                                    ?><a href="#!" class="secondary-content"><i class="material-icons"></i></a>
                                </p>
                            </div>
                        </li>
                        <li class="collection-item">
                            <div>
                                <p>
                                    <span class="quantity"></span>
                                    <span class="label green"><strong>Faculty</strong></span>
                                    <?php
                                    $faculty=\common\models\faculty\FacultyRecord::findOne($program->faculty_id);
                                    echo $faculty->name;
                                    ?>
                                    <a href="#!" class="secondary-content"><i class="material-icons"></i></a>
                                </p>
                            </div>
                        </li>
                        <li class="collection-item">
                            <div>
                                <p>
                                    <span class="quantity"></span>
                                    <span class="label green"><strong>University</strong></span>
                                    <?php
                                    $univ=\common\models\university\UniversityRecord::findOne($faculty->university_id);
                                    echo $univ->name;
                                    ?>
                                    <a href="#!" class="secondary-content"><i class="material-icons"></i></a>
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div id="likedislikediv">',
                    <?php echo $this->render('_likedislike', array('model'=>$model)); ?>
                </div>
                </p>

            </div>
        </div>
    </div>
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
        }
        ?>
<?php echo LinkPager::widget([
'pagination' => $pages,
]);
?>
<?php $this->render('_suggestions');?>
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

