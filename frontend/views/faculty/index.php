<?php
use yii\helpers\Html;
?>
<ul>
    <?php

    foreach($model as $m)
    {
        ?>
        <li>
            <?= Html::a($m->name, ['/program/index','faculty_id'=>$m->id]) ?>
        </li>
    <?php
    }?>
</ul>