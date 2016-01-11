<?php
use yii\helpers\Html;
?>
<div>
    <ul>

        <li> <?= Html::a('Upload pdf',['/content/create','label'=>'pdf','id'=>$id],['class'=>'glyphicon glyphicon-paperclip']);?></li>
        <li> <?= Html::a('Upload image',['/content/create','label'=>'image','id'=>$id],['class'=>'glyphicon glyphicon-picture']);?></li>
        <li> <?= Html::a('Upload videos',['/content/create','label'=>'video','id'=>$id],['class'=>'glyphicon glyphicon-facetime-video']);?></li>
    </ul>
</div>