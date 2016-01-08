<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\program\ProgramRecord */

$this->title = 'Update Program Record: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Program Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="program-record-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
