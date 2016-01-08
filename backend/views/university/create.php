<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\university\UniversityRecord */

$this->title = 'Create University Record';
$this->params['breadcrumbs'][] = ['label' => 'University Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="university-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
