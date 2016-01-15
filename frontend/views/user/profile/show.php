<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \dektrium\user\models\Profile $profile
 */

$this->title = empty($profile->name) ? Html::encode($profile->user->username) : Html::encode($profile->name);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-9">
                            <h2><?= Html::encode($profile->user->username)?></h2>
                            <?php if (!empty($profile->location)): ?>
                                <p><strong>Location: </strong><?= Html::encode($profile->location) ?> </p>
                            <?php endif; ?>
                            <?php if (!empty($profile->website)): ?>
                                <p><strong>Website: </strong><?= Html::encode($profile->website) ?> </p>
                            <?php endif; ?>
                            <?php if (!empty($profile->public_email)): ?>
                                <p><strong>Email: </strong><?= Html::a(Html::encode($profile->public_email), 'mailto:' . Html::encode($profile->public_email)) ?> </p>
                            <?php endif; ?>
                            <p><strong>Skills: </strong>
                                <span class="label label-info tags">html5</span>
                                <span class="label label-info tags">css3</span>
                                <span class="label label-info tags">jquery</span>
                                <span class="label label-info tags">bootstrap3</span>
                            </p>
                        </div><!--/col-->
                        <div class="col-xs-12 col-sm-3 text-center">
                            <img src="http://api.randomuser.me/portraits/men/49.jpg" alt="" class="center-block img-circle img-responsive">
                            <ul class="list-inline ratings text-center" title="Ratings">
                                <li><a href="#"><span class="fa fa-star fa-lg"></span></a></li>
                                <li><a href="#"><span class="fa fa-star fa-lg"></span></a></li>
                                <li><a href="#"><span class="fa fa-star fa-lg"></span></a></li>
                                <li><a href="#"><span class="fa fa-star fa-lg"></span></a></li>
                                <li><a href="#"><span class="fa fa-star fa-lg"></span></a></li>
                            </ul>
                        </div><!--/col-->

                        <div class="col-xs-12 col-sm-4">
                            <h2><strong><?= Html::a($follower->count(), ['/follow/followers','id'=>$id])?></strong></h2>
                            <p><small>Followers</small></p>
                            <?php
                            $follow_btn_class='';
                            if ($id==\Yii::$app->user->identity->getId()):
                                $follow_btn_class='disabled';
                             endif; ?>
                            <button class="btn btn-success btn-block <?= $follow_btn_class?>"><span class="fa fa-plus-circle"></span> Follow </button>
                        </div><!--/col-->
                        <div class="col-xs-12 col-sm-4">
                            <h2><strong><?= Html::a($following->count(), ['/follow/followings','id'=>$id])?></strong></h2>
                            <p><small>Following</small></p>
                            <?php
                            $profile_btn_class='';
                            if ($id!=\Yii::$app->user->identity->getId()):
                                $profile_btn_class='hidden';
                            endif; ?>
                            <a href="<?php echo Url::toRoute('/user/admin/updatefromuser').'?id='. $id;?>">
                            <button class="btn btn-info btn-block <?= $profile_btn_class?>"><span class="fa fa-user"></span> View Profile </button>
                        </div><!--/col-->
                        <div class="col-xs-12 col-sm-4">
                            <h2><strong><?= Html::a($followed_programs->count(), ['/follow/followedprograms','id'=>$id])?></strong></h2>
                            <p><small>Programs Followed</small></p>
                            <button type="button" class="btn btn-primary btn-block"><span class="fa fa-gear"></span> Options </button>
                        </div><!--/col-->
                    </div><!--/row-->
                </div><!--/panel-body-->
            </div><!--/panel-->
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="alert alert-info">
                <h2><?= Html::encode($profile->user->username)?> Bio : </h2>
                <h4>Bootstrap user profile template </h4>
                <p>
                    <?php if(!empty($profile->bio)):?>
                    <?= Html::encode($profile->bio)?>
                    <?php endif;?>
                    <?php if(empty($profile->bio)):?>
                        <span class="text-center"> Bio Not Available</span>
                    <?php endif;?>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
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
                        foreach ($model_pdf as $model)
                        {
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
                        foreach ($model_img as $model)
                        {
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
        </div>
    </div>
</div>
