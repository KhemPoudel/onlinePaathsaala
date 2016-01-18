<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\course\CourseRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>



    <div class="form-group">
        <?= Html::submitButton('create',['create','id'=>$program_id],['class'=>'btn
    btn-primary']) ?>
    </div>
    <div class="form-group">
        <?= Html::a('back',['/course/back','id'=>$program_id],['class'=>'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
