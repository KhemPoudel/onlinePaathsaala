<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <span><strong><?= $program->name;?></strong></span>
    </div>
    <div class="panel-body">
        <div style="border-bottom: groove">
            <h4>Videos</h4>
        </div>
        <br>
        <ul class="list-unstyled video-list-thumbs row">
            <?php
            if(empty($model_videos))
            {?>
                <span class="text-center" style="color: rgba(37, 140, 235, 0.17);"><h3>Nothing to Show</h3></span>
            <?php
            }
            foreach($model_videos as $model)
            {
                ?>
                <li class="col-lg-3 col-sm-4 col-xs-6">
                    <a href="<?php echo Url::toRoute('/content/viewsingle').'?id='. $model->id;?>" title=<?php echo $model->name;?>>
                        <p style="height: 130px;">
                            <?php echo Html::img('@web/images/video_thumbnail.jpg', ['height' => '70%']); ?>
                        </p>

                        <h2><?php echo $model->name;?></h2>
                        <span class="glyphicon glyphicon-play-circle"></span>
                        <span class="duration">03:15</span>
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>
        <div style="border-bottom: groove">
            <h4>PDFs</h4>
        </div>
        <br>
        <ul class="list-unstyled video-list-thumbs row">
            <?php
            if(empty($model_pdf))
            {?>
                <span class="text-center" style="color: rgba(37, 140, 235, 0.17);"><h3>Nothing to Show</h3></span>
            <?php
            }
            foreach ($model_pdf as $model) {
                ?>
                <li class="col-lg-3 col-sm-4 col-xs-6">
                    <a href=<?php echo Url::base() . '/assets/Uploads/' . $model->name;?> target='_blank' title=<?php echo $model->name;?>>

                        <p style="height:  130px;"?>
                            <?php echo Html::img('@web/images/pdf_thumbnail.png', ['height' => '140px']); ?>
                        </p>
                        <h2><?= $model->name;?></h2>
                    </a>
                </li>

            <?php
            }
            ?>
        </ul>

        <div style="border-bottom: groove">
            <h4>Images</h4>
        </div>
        <br>
        <ul class="list-unstyled video-list-thumbs row">
            <?php
            if(empty($model_img))
            {?>
                <span class="text-center" style="color: rgba(37, 140, 235, 0.17);"><h3>Nothing to Show</h3></span>
            <?php
            }
            foreach ($model_img as $model) {
                ?>
                <li class="col-lg-3 col-sm-4 col-xs-6">
                    <a title=<?php echo $model->name;?>>

                        <p style="height:  130px;"?>
                            <?php echo Html::img('@web/assets/uploads/'.$model->name, ['height' => '140px']); ?>
                        </p>
                        <h2><?= $model->name;?></h2>
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
</div>