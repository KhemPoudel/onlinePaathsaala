<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\faculty\FacultySearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Faculty Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faculty-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Faculty Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'level',
            'university_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
