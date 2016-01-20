<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\conrec\Conrec */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Conrecs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="conrec-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'topic_id',
            'type',
            'ext',
            'uploadedBy',
            'address',
            'postedAt',
            'flag',
        ],
    ]) ?>

</div>
