<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\program\ProgramRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="program-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <div class="form-group">
        <?= Html::submitButton('create',['create','id'=>$faculty_id],['class'=>'btn
    btn-primary']) ?>
    </div>
    <div class="form-group">
        <?= Html::a('back',['/program/back','id'=>$faculty_id],['class'=>'btn btn-primary'])?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
