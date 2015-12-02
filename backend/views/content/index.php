<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\content\ContentSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Content Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Content Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'topic_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
