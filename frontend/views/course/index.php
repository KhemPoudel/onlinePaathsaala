
<?php
use yii\helpers\Html;
$program=\common\models\faculty\FacultyRecord::findOne($program_id)->name;
$breadcrumbs=$university.' / '.$faculty.' / '.$program;
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
            <?= \yii\bootstrap\Html::a($link,['/topic/index','course_id'=>$model->id,'university'=>$university,'faculty'=>$faculty,'program'=>$program]);?>
            <p class="list-group-item-text">
            </p>
        </div>
    <?php
    }?>
</ul>