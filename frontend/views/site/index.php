<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\Collapse;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>



<div class="body-content pull-left">
    <?php
    foreach($models as $model)
    {
        echo '
        <div class="panel panel-default">
                                 <div class="panel-heading"> <p><h4>',\dektrium\user\models\User::findOne(['id'=>$model->uploadedBy])->username,'</h4>added ',$model->name,'</p></div>
                                  <div class="panel-body">';

        if($model->type=='video')
        {
            echo '
                    <video id="video" width="640" height="480" poster="" controls>
                        <source src=',Url::base() . '/assets/Uploads/' . $model->name,' type="video','/',$model->ext, '">
                    </video>
                </div>
            ';
        }
        else{
            echo
            Html::a($model->name, Url::base() . '/assets/Uploads/' . $model->name,['title'=>$model->name,'target'=>'_blank']),
            '<br/>
            <object data=',Url::base() . '/assets/Uploads/' . $model->name,' type="application/pdf" width="640" height="480">
                alt : <a href=',Url::base() . '/assets/Uploads/' . $model->name,'>',$model->name,'</a>
</object>
                </div>
            ';
        }
        echo '<div class="clearfix"></div>';
        echo '
        <div id="likedislikediv">',
            $this->render('_likedislike', array('model'=>$model))
        ,'</div>

        ';
        //print_r($model->getLikesDislikes());
foreach($model->getLikesDislikes() as $likes)
{
    //print_r($likes['type']);
}
echo Collapse::widget([
    'items' => [
        // equivalent to the above
        [
            'label' => 'View Discussions',
            'content' => $this->context->getComments($model),
            // open its content by default
            'contentOptions' => ['class' => 'out'],
        ],
    ]
]);
       echo '</div>';
    }
    ?>

</div>

<?php echo LinkPager::widget([
'pagination' => $pages,
]);
?>