<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm; // or yii\widgets\ActiveForm
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\content\ContentRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    echo FileInput::widget([
       'name'=>'file',
        'options'=>[
            'multiple'=>true
        ],
        'pluginOptions'=>[
            'uploadUrl'=>\yii\helpers\Url::to('/onlinePaathsaala/frontend/web/index.php/content/create')
        ]
    ]);
?>
