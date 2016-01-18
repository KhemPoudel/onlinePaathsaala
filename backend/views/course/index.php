<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\course\CourseSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Course Records';
$this->params['breadcrumbs'][] = ['label' => $name->name, 'url' => ['program/index','id'=>$name->faculty_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Course Record', ['create','id'=>$name->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',


            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {topic/index}',

                'buttons' => [


                    'update' => function ($url,$model) {

                        return Html::a(

                            '<span class="glyphicon glyphicon-user"></span>',

                            $url);

                    },
                    'topic/index'=>function($url,$model,$key)
                    {

                        return Html::a('<span class="btn btn-primary">topics</span>',$url);
                    },



                ],
            ],
        ],
    ]); ?>

</div>
