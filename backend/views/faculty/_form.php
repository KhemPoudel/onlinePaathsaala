<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\faculty\FacultyRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="faculty-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'level')->textInput(['maxlength' => true]) ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
<div class="form-group">
    <?= Html::a('done',['/faculty/next','dataProvider'=>$dataProvider],['class'=>'btn btn-primary'])?>
</div>
    <?php ActiveForm::end(); ?>

</div>
