
<?php
use yii\helpers\Html;
$this->params['breadcrumbs'][] = 'University';
?>
<ul>
<?php

foreach($model as $model)
{
    ?>
    <?php
    $link='<h4 class="list-group-item-heading">'.$model->name.'</h4>';
    ?>
    <div class="list-group-item">
        <?= \yii\bootstrap\Html::a($link,['/faculty/index','university_id'=>$model->id]);?>
        <p class="list-group-item-text">
            <?= $model->location;?>
        </p>
    </div>
    <?php
}?>
    </ul>