<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\content\ContentRecord */

$this->title = 'Create Content Record';
$this->params['breadcrumbs'][] = ['label' => 'Content Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
