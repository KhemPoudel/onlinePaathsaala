<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div id="video-tab" class="tab-pane fade in active">
    <?php
    if(empty($model_videos))
    {
        ?>
        <span class="text-center" style="color: rgba(37, 140, 235, 0.17);"><h3>Nothing to Show</h3></span>
    <?php
    }
    ?>
    <?php
    $i=0;
    foreach($model_videos as $model)
    {
        if($i%2==0)
        {
            ?>
            <div class="row">
            <div class="horizontal-panel">
        <?php
        }
        ?>
        <div class="col-md-6">
            <!--Featured card-->
            <div class="card-noborder hoverable" id="content-div-<?=$model->id;?>">
                <div class="view overlay hm-white-slight">
                    <video id="video" width="100%" height="100%" class="video-class" controls>
                        <source src="<?=Url::base()?>/assets/Uploads/<?= $model->address?>" type="video/<?=$model->ext?>">
                    </video>
                </div>
                <div class="card-content">
                    <p>
                        <h5 class="title"><a href="<?php echo Url::toRoute('/content/viewsingle').'?id='. $model->id;?>"><?=$model->name;?></a></h5>
                        <?php
                            if($model->uploadedBy==\Yii::$app->user->identity->getId())
                            {
                                ?>
                                <i class="fa fa-trash-o pull-right delete-content" data-id="<?=$model->id;?>"></i>
                                <?php
                            }
                        ?>
                    </p>

                    <ul class="list-inline item-details">
                        <li><i class="fa fa-thumbs-o-up"></i><?=$this->context->getLikes($model);?></li>
                        <li><i class="fa fa-thumbs-o-down"> </i> <?=$this->context->getDislikes($model);?></li>
                        <li><i class="fa fa-comment-o"> </i><?=$this->context->getCommentsCount($model);?></li>
                    </ul>
                    <p>
                        <span class="label label-green">
                        <strong>
                            <?php
                            $topic=\common\models\topic\TopicRecord::findOne($model->topic_id);
                            $course=\common\models\course\CourseRecord::findOne($topic->course_id);
                            $program=\common\models\program\ProgramRecord::findOne($course->program_id);
                            $faculty=\common\models\faculty\FacultyRecord::findOne($program->faculty_id);
                            $univ=\common\models\university\UniversityRecord::findOne($faculty->university_id);
                            echo Html::a($topic->name,['/content/index','topic_id'=>$topic->id,'university'=>$univ->name,'faculty'=>$faculty->name,'program'=>$program->name,'course'=>$course->name],['style'=>'color:black;']);
                            ?>
                        </strong>
                        </span>
                <span class="label blue">
                    <strong>
                        <?php
                        echo Html::a($course->name,['/topic/index','course_id'=>$course->id,'university'=>$univ->name,'faculty'=>$faculty->name,'program'=>$program->name],['style'=>'color:black;']);
                        ?>
                    </strong>
                </span>
                <span class="label blue-grey">
                    <strong>
                        <?php
                        echo Html::a($program->name,['/course/index','program_id'=>$program->id,'university'=>$univ->name,'faculty'=>$faculty->name],['style'=>'color:black;']);
                        ?>
                    </strong>
                </span>
                <span class="label default-color">
                    <strong>
                        <?php
                        echo Html::a($faculty->name,['/program/index','faculty_id'=>$faculty->id,'university'=>$univ->name],['style'=>'color:black;']);
                        ?>
                    </strong>
                </span>
                <span class="label orange">
                    <strong>
                        <?php
                        echo Html::a($univ->name,['/faculty/index','university_id'=>$univ->id],['style'=>'color:black;']);
                        ?>
                    </strong>
                </span>
                    </p>
                </div>
            </div>
            <!--/.Featured card-->
        </div>
        <?php if($i%2==1 or $model==end($model_videos))
    {   ?>

        </div><!--end of horizontal plane-->

        </div><!--end of row-->
    <?php
    }
        ?>
        <?php
        $i++;
    }
    ?>
</div>
<div id="pdf-tab" class="tab-pane fade in">
    <?php
    if(empty($model_pdf))
    {
        ?>
        <span class="text-center" style="color: rgba(37, 140, 235, 0.17);"><h3>Nothing to Show</h3></span>
    <?php
    }
    ?>
    <?php
    $i=0;
    foreach($model_pdf as $model)
    {
        if($i%2==0)
        {
            ?>
            <div class="row">
            <div class="horizontal-panel">
        <?php
        }
        ?>
        <div class="col-md-6">
            <!--Featured card-->
            <div class="card-noborder hoverable" id="content-div-<?=$model->id;?>">
                <div class="view overlay hm-white-slight">
                    <a href=<?php echo Url::base() . '/assets/Uploads/' . $model->address;?> target='_blank'>
                        <?= Html::img('@web/images/pdf_thumbnail.png',['class'=>"img-responsive"])?>
                    </a>
                </div>

                <div class="card-content">
                    <h5 class="title"><a href="<?php echo Url::toRoute('/content/viewsingle').'?id='. $model->id;?>">
                            <?=$model->name;?></a>
                    </h5>
                    <?php
                    if($model->uploadedBy==\Yii::$app->user->identity->getId())
                    {
                        ?>
                        <i class="fa fa-trash-o pull-right delete-content" data-id="<?=$model->id?>"></i>
                    <?php
                    }
                    ?>
                    <ul class="list-inline item-details">
                        <li><i class="fa fa-thumbs-o-up"></i><?=$this->context->getLikes($model);?></li>
                        <li><i class="fa fa-thumbs-o-down"> </i> <?=$this->context->getDislikes($model);?></li>
                        <li><i class="fa fa-comment-o"> </i><?=$this->context->getCommentsCount($model);?></li>
                    </ul>

                    <p>
                                                <span class="label label-green">
                        <strong>
                            <?php
                            $topic=\common\models\topic\TopicRecord::findOne($model->topic_id);
                            $course=\common\models\course\CourseRecord::findOne($topic->course_id);
                            $program=\common\models\program\ProgramRecord::findOne($course->program_id);
                            $faculty=\common\models\faculty\FacultyRecord::findOne($program->faculty_id);
                            $univ=\common\models\university\UniversityRecord::findOne($faculty->university_id);
                            echo Html::a($topic->name,['/content/index','topic_id'=>$topic->id,'university'=>$univ->name,'faculty'=>$faculty->name,'program'=>$program->name,'course'=>$course->name],['style'=>'color:black;']);
                            ?>
                        </strong>
                        </span>
                <span class="label blue">
                    <strong>
                        <?php
                        echo Html::a($course->name,['/topic/index','course_id'=>$course->id,'university'=>$univ->name,'faculty'=>$faculty->name,'program'=>$program->name],['style'=>'color:black;']);
                        ?>
                    </strong>
                </span>
                <span class="label blue-grey">
                    <strong>
                        <?php
                        echo Html::a($program->name,['/course/index','program_id'=>$program->id,'university'=>$univ->name,'faculty'=>$faculty->name],['style'=>'color:black;']);
                        ?>
                    </strong>
                </span>
                <span class="label default-color">
                    <strong>
                        <?php
                        echo Html::a($faculty->name,['/program/index','faculty_id'=>$faculty->id,'university'=>$univ->name],['style'=>'color:black;']);
                        ?>
                    </strong>
                </span>
                <span class="label orange">
                    <strong>
                        <?php
                        echo Html::a($univ->name,['/faculty/index','university_id'=>$univ->id],['style'=>'color:black;']);
                        ?>
                    </strong>
                </span>
                    </p>
                </div>
            </div>
            <!--/.Featured card-->
        </div>
        <?php if($i%2==1 or $model==end($model_pdf))
    {
        ?>

        </div><!--end of horizontal plane-->

        </div><!--end of row-->
    <?php
    }
        ?>
        <?php
        $i++;
    }
    ?>
</div>
<div id="img-tab" class="tab-pane fade in">
    <?php
    if(empty($model_img))
    {
        ?>
        <span class="text-center" style="color: rgba(37, 140, 235, 0.17);"><h3>Nothing to Show</h3></span>
    <?php
    }
    ?>
    <?php
    $i=0;
    foreach($model_img as $model)
    {
        if($i%2==0)
        {
            ?>
            <div class="row">
            <div class="horizontal-panel">
        <?php
        }
        ?>
        <div class="col-md-6">
            <!--Featured card-->
            <div class="card-noborder hoverable" id="content-div-<?=$model->id;?>">
                <div class="view overlay hm-white-slight" style="width: 300px;
                height: 200px;
                 overflow: hidden;">
                        <?= Html::img('@web/assets/Uploads/'.$model->address,['class'=>"img-responsive",'style'=>' position: relative;
                            float: left;
                            width:  380px;
                            height: 189px;'])?>
                </div>

                <div class="card-content">
                    <h5 class="title">
                        <a href="<?php echo Url::toRoute('/content/viewsingle').'?id='. $model->id;?>"><?=$model->name;?></a>
                    </h5>
                    <?php
                    if($model->uploadedBy==\Yii::$app->user->identity->getId())
                    {
                        ?>
                        <i class="fa fa-trash-o pull-right delete-content" data-id="<?=$model->id;?>"></i>
                    <?php
                    }
                    ?>
                    <ul class="list-inline item-details">
                        <li><i class="fa fa-thumbs-o-up"></i><?=$this->context->getLikes($model);?></li>
                        <li><i class="fa fa-thumbs-o-down"> </i> <?=$this->context->getDislikes($model);?></li>
                        <li><i class="fa fa-comment-o"> </i><?=$this->context->getCommentsCount($model);?></li>
                    </ul>
                    <p>
                                                <span class="label label-green">
                        <strong>
                            <?php
                            $topic=\common\models\topic\TopicRecord::findOne($model->topic_id);
                            $course=\common\models\course\CourseRecord::findOne($topic->course_id);
                            $program=\common\models\program\ProgramRecord::findOne($course->program_id);
                            $faculty=\common\models\faculty\FacultyRecord::findOne($program->faculty_id);
                            $univ=\common\models\university\UniversityRecord::findOne($faculty->university_id);
                            echo Html::a($topic->name,['/content/index','topic_id'=>$topic->id,'university'=>$univ->name,'faculty'=>$faculty->name,'program'=>$program->name,'course'=>$course->name],['style'=>'color:black;']);
                            ?>
                        </strong>
                        </span>
                <span class="label blue">
                    <strong>
                        <?php
                        echo Html::a($course->name,['/topic/index','course_id'=>$course->id,'university'=>$univ->name,'faculty'=>$faculty->name,'program'=>$program->name],['style'=>'color:black;']);
                        ?>
                    </strong>
                </span>
                <span class="label blue-grey">
                    <strong>
                        <?php
                        echo Html::a($program->name,['/course/index','program_id'=>$program->id,'university'=>$univ->name,'faculty'=>$faculty->name],['style'=>'color:black;']);
                        ?>
                    </strong>
                </span>
                <span class="label default-color">
                    <strong>
                        <?php
                        echo Html::a($faculty->name,['/program/index','faculty_id'=>$faculty->id,'university'=>$univ->name],['style'=>'color:black;']);
                        ?>
                    </strong>
                </span>
                <span class="label orange">
                    <strong>
                        <?php
                        echo Html::a($univ->name,['/faculty/index','university_id'=>$univ->id],['style'=>'color:black;']);
                        ?>
                    </strong>
                </span>
                    </p>
                </div>
            </div>
            <!--/.Featured card-->
        </div>
        <?php if($i%2==1 or $model==end($model_img))
    {
        ?>

        </div><!--end of horizontal plane-->

        </div><!--end of row-->
    <?php
    }
        ?>
        <?php
        $i++;
    }
    ?>
</div>
<?php
$js= <<<JS
    $('.delete-content').on('click',function(){
        var content_id=$(this).attr('data-id');
        var data={'id':content_id};
        if(confirm('Are you sure??'))
        {
        $.ajax({
                url:'profile/deletecontent',
                dataType:"json",
                type:'post',
                data: data,
                success: function(response) {
                    $("#content-div-"+content_id).html('<p class="text-center"><h5>Deleted</h5></p>');
                    console.log(response);

                }
       });
        }

    });
JS;
$this->registerJs($js);
