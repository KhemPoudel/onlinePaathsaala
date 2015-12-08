<?php
use yii\helpers\Html;
?>
<ul>
<?php

foreach($model as $m)
{
    ?>
    <li>
        <?= Html::a($m->name, ['/faculty/index','university_id'=>$m->id]) ?>
    </li>
<?php
}?>
    </ul>