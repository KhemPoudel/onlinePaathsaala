<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div>
    <ul>

        <li> <?= Html::a('Upload pdf',['/contents/create','label'=>'pdf'],['class'=>'glyphicon glyphicon-paperclip']);?></li>
        <li> <?= Html::a('Upload image',['/contents/create','label'=>'image'],['class'=>'glyphicon glyphicon-picture']);?></li>
        <li> <?= Html::a('Upload videos',['/contents/create','label'=>'video'],['class'=>'glyphicon glyphicon-facetime-video']);?></li>
    </ul>
</div>