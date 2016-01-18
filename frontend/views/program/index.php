
<?php
use yii\helpers\Html;
$faculty=\common\models\faculty\FacultyRecord::findOne($faculty_id)->name;
$breadcrumbs=$university.'/'.$faculty;
$this->params['breadcrumbs'][] = $breadcrumbs;
?>
<ul>
    <?php

    foreach($models as $model)
    {
        ?>
        <?php
        $link='<h4 class="list-group-item-heading">'.$model->name.'</h4>';
        ?>
        <div class="list-group-item">
            <?= \yii\bootstrap\Html::a($link,['/course/index','program_id'=>$model->id,'university'=>$university,'faculty'=>$faculty]);?>
            <p class="list-group-item-text">
            </p>
        </div>
    <?php
    }?>
</ul>