<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm; // or yii\widgets\ActiveForm
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\content\ContentRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-record-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<?php
if($label=='image')
{
    echo $form->field($model, 'topic_id')->textInput(['value'=>$topic_id]);
       echo $form->field($model, $label)->widget(FileInput::classname(), [
    'options'=>['accept'=>$label.'/*'],
    'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']]]);
}
elseif($label=='pdf'){
    echo $form->field($model, 'topic_id')->textInput(['value'=>$topic_id]);
    echo $form->field($model, $label)->widget(FileInput::classname(), [
        'options'=>['accept'=>$label.'/*'],
        'pluginOptions'=>['allowedFileExtensions'=>['pdf']]]);
}
elseif($label=='video'){
    echo $form->field($model, 'topic_id')->textInput(['value'=>$topic_id]);
    echo $form->field($model, $label)->widget(FileInput::classname(), [
        'options'=>['accept'=>$label.'/*'],
        'pluginOptions'=>['allowedFileExtensions'=>['webm']]]);
}
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
