<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\course\CourseRecord */

$this->title = 'Create Course Record';
$this->params['breadcrumbs'][] = ['label' => 'Course Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'program_id'=>$id
    ]) ?>

</div>
