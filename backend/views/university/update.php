<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\university\UniversityRecord */

$this->title = 'Update University Record: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'University Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="university-record-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
