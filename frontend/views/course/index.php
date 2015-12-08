<?php
use yii\helpers\Html;
?>
<ul>
    <?php

    foreach($model as $m)
    {
        ?>
        <li>
            <?= Html::a($m->name, ['/topic/index','course_id'=>$m->id]) ?>
        </li>
    <?php
    }?>
</ul>