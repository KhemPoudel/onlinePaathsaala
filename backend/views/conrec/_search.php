<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\conrec\ConrecSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="conrec-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'topic_id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'ext') ?>

    <?php // echo $form->field($model, 'uploadedBy') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'postedAt') ?>

    <?php // echo $form->field($model, 'flag') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
