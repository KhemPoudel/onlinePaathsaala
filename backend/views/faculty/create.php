<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\faculty\FacultyRecord */

$this->title ='faculty record';
$this->params['breadcrumbs'][] = ['label' => 'Faculty Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faculty-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'dataProvider'=>$dataProvider,
    ]) ?>

</div>
