<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\university\UniversitySearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'University Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="university-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create University Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'location',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {faculty/create}{faculty/index}',

                'buttons' => [


                    'update' => function ($url,$model) {

                        return Html::a(

                            '<span class="glyphicon glyphicon-user"></span>',

                            $url);

                    },
                    'faculty/create'=>function($url,$model)
                    {
                        return Html::a('<span class="btn btn-primary">add faculty</span>',$url);
                    },

                    'faculty/index'=>function($url,$model){
                        return Html::a('<span class="btn btn-primary">faculties</span>',$url);
                    }

                ],
            ],
        ],
    ]); ?>

</div>
