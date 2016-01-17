
<?php
use yii\helpers\Html;
$program=\common\models\program\ProgramRecord::findOne($program_id)->name;
?>
<div class="card-panel horizontal-listing no-padding search-class">
    <div class="container-fluid">
        <h4 class="black-text"><?=$program;?><i class="material-icons"></i></h4>
        <hr>
        <?php
        foreach($models as $model)
        {
            $topics=\common\models\topic\TopicRecord::find()->where(['course_id'=>$model->id]);
            ?>
            <a>
                <div class="row hoverable">
                    <div class="col-sm-4">
                        <img src="http://mdbootstrap.com/images/reg/reg%20(54).jpg" class="img-responsive z-depth-2">
                    </div>
                    <div class="col-sm-8">
                        <?php
                        $link_course='<h5 class="title">'.$model->name.'</h5>';
                        echo Html::a($link_course,['/topic/index','course_id'=>$model->id,'university'=>$university,'faculty'=>$faculty,'program'=>$program]);
                        ?>
                        <ul class="list-inline item-details">
                            <li><i class="fa fa-clock-o"> 05/10/2015 | </i></li>
                            <li><a>Topics <?=$topics->count();?></a></li>
                        </ul>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores illum impedit dolor possimus architecto labore.</p>
                    </div>
                </div>
            </a>
        <?php
        }
        ?>
    </div>
</div>
<!--/.1 Column horizontal listing-->