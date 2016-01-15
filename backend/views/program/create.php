<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\program\ProgramRecord */

$this->title = 'Create Program Record';
$this->params['breadcrumbs'][] = ['label' => 'Program Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="program-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'faculty_id'=>$id,
    ]) ?>

</div>
