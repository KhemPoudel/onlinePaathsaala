<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\program\ProgramSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Program Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="program-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Program Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'faculty_id',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {course/create}{course/index}',

                'buttons' => [


                    'update' => function ($url,$model) {

                        return Html::a(

                            '<span class="glyphicon glyphicon-user"></span>',

                            $url);

                    },
                    'course/create'=>function($url,$model)
                    {
                        return Html::a('<span class="btn btn-primary">add course</span>',$url);
                    },

                    'course/index'=>function($url,$model){
                        return Html::a('<span class="btn btn-primary">courses</span>',$url);
                    }

                ],
                ],
    ],
    ]); ?>

</div>
