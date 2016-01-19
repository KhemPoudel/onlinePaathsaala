<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\conrec\ConrecSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Conrecs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="conrec-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Conrec', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'topic_id',
            'type',
            'ext',
            // 'uploadedBy',
            // 'address',
            // 'postedAt',
            // 'flag',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
