<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\topic\TopicRecord */

$this->title = 'Create Topic Record';
$this->params['breadcrumbs'][] = ['label' => 'Topic Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'parent_id'=>$parent_id,
       'lvl'=>$level,
        'course_id'=>$course_id,

    ]) ?>

</div>
