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

        <?= Html::a('Main Topic', ['create','parent_id'=>"" ,'level'=>1,'course_id'=>$id], ['class' => 'btn btn-success']) ?>
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
            'level',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {topic/provider}{topic/show}{content/upload}',

                'buttons' => [


                    'update' => function ($url,$model) {

                        return Html::a(

                            '<span class="glyphicon glyphicon-user"></span>',

                            $url);

                    },
                    'topic/show'=>function($url,$model,$key)
                    {

                        return Html::a('<span class="btn btn-primary">sub topics</span>',$url);
                    },
                    'topic/provider'=>function($url,$model,$key)
                    {

                        return Html::a('<span class="btn btn-primary">create sub</span>',$url);
                    },

                    'content/upload'=>function($url)
                    {
                        return Html::a('<span class="btn btn-primary">add content</span>',$url);
                    }


                ],
            ],
        ],
    ]); ?>

</div>
