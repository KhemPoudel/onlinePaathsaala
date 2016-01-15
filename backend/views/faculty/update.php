<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\faculty\FacultyRecord */

$this->title = 'Update Faculty Record: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Faculty Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="faculty-record-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'dataProvider'=>$model->id,
    ]) ?>

</div>
