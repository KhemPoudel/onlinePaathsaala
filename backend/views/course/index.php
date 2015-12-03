<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\course\CourseSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Course Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Course Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'program_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
