<?php
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/thumbnail.js', ['position'=>$this::POS_READY]);
use yii\helpers\Html;
use yii\helpers\Url;
?>
<ul>
    <?php

    foreach($model as $m)
    {
        ?>
        <li>
            <?php if($m->type=='video'){
                ?>
                <video id="video" width="320" height="240" poster="" controls>
                    <source src=<?= Url::base() . '/assets/Uploads/' . $m->name?> type="video/<?php echo $m->ext;?>">
                    Your browser does not support the video tag.
                </video>
            <?php
            }
            else
            ?>
            <?=Html::a($m->name, Url::base() . '/assets/Uploads/' . $m->name,['title'=>$m->name,'target'=>'_blank']);?>
        </li>
    <?php
    }?>
</ul>