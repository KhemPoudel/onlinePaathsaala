
<?php
use yii\helpers\Html;
$university=\common\models\university\UniversityRecord::findOne($university_id)->name;
$this->params['breadcrumbs'][] = $university;
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
            <?= \yii\bootstrap\Html::a($link,['/program/index','faculty_id'=>$model->id,'university'=>$university]);?>
            <p class="list-group-item-text">
            </p>
        </div>
    <?php
    }?>
</ul>