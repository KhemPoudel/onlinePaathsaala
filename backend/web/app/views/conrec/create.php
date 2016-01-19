<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\conrec\Conrec */

$this->title = 'Create Conrec';
$this->params['breadcrumbs'][] = ['label' => 'Conrecs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="conrec-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
