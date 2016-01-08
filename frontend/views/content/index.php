<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<ul>
    <?php

    foreach($model as $m)
    {
        ?>
        <li>
            <?=Html::a($m->name, Url::base() . '/assets/Uploads/' . $m->name,['title'=>$m->name,'target'=>'_blank']);?>
        </li>
    <?php
    }?>
</ul>