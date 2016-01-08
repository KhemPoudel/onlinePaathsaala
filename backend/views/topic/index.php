<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\topic\TopicSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Topic Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Topic Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'course_id',
            'parent_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
