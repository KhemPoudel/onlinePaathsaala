<?php
use yii\helpers\Html;
?>
<!--1 Coulm horizontal listing-->
<div class="card-panel horizontal-listing no-padding search-class">
    <div class="container-fluid">
        <h4 class="black-text">Notifications</h4>
        <hr>
        <?php
        foreach($models as $model)
        {
            if($model->flag==1)
                $status='<span class="label label-green">approved</span>';
            elseif($model->flag==0)
                $status='<span class="label label-danger">rejected</span>';
            else
                $status='<span class="label label-info">Pending</span>';
            ?>
            <a>
                <div class="row hoverable">
                    <div class="col-sm-12">
                        <?php
                        $link_faculty='<h5 class="title">'.$model->name.'</h5>';
                        echo Html::a($link_faculty,['/content/viewsingle','id'=>$model->id]);
                        ?>
                        <p><strong>Status: </strong><?=$status;?></p>
                        <ul class="list-inline item-details">
                            <li><i class="fa fa-clock-o"></i> <?=Yii::t('user', '{0, date}', $model->posted_at);?></li>
                        </ul>

                    </div>
                </div>
            </a>
        <?php
        }
        ?>
    </div>
</div>
<!--/.1 Column horizontal listing-->