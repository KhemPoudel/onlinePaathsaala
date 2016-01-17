
<?php
use yii\helpers\Html;
$faculty=\common\models\faculty\FacultyRecord::findOne($faculty_id)->name;
$breadcrumbs=$university.'/'.$faculty;
$this->params['breadcrumbs'][] = $breadcrumbs;
?>

<div class="card-panel horizontal-listing no-padding search-class">
    <div class="container-fluid">
        <h4 class="black-text"><?=$faculty?><i class="material-icons"></i></h4>
        <hr>
        <?php
        foreach($models as $model)
        {
            $courses=\common\models\course\CourseRecord::find()->where(['program_id'=>$model->id]);
            ?>
            <a>
                <div class="row hoverable">
                    <div class="col-sm-4">
                        <img src="http://mdbootstrap.com/images/reg/reg%20(54).jpg" class="img-responsive z-depth-2">
                    </div>
                    <div class="col-sm-8">
                        <?php
                        $link_program='<h5 class="title">'.$model->name.'</h5>';
                        echo Html::a($link_program,['/course/index','program_id'=>$model->id,'faculty'=>$faculty,'university'=>$university]);
                        ?>
                        <ul class="list-inline item-details">
                            <li><i class="fa fa-clock-o"> 05/10/2015 | </i></li>
                            <li><a>Courses <?=$courses->count();?></a></li>
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