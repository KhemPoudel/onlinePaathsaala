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

/**
 * @var \yii\web\View $this
 * @var \dektrium\user\models\Profile $profile
 */

$this->title = empty($profile->name) ? Html::encode($profile->user->username) : Html::encode($profile->name);
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6">
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <img src="http://gravatar.com/avatar/<?= $profile->gravatar_id ?>?s=230" alt="" class="img-rounded img-responsive" />
            </div>
            <div class="col-sm-6 col-md-8">
                <h4><?= $this->title ?></h4>
                <ul style="padding: 0; list-style: none outside none;">
                    <?php if (!empty($profile->location)): ?>
                        <li><i class="glyphicon glyphicon-map-marker text-muted"></i> <?= Html::encode($profile->location) ?></li>
                    <?php endif; ?>
                    <?php if (!empty($profile->website)): ?>
                        <li><i class="glyphicon glyphicon-globe text-muted"></i> <?= Html::a(Html::encode($profile->website), Html::encode($profile->website)) ?></li>
                    <?php endif; ?>
                    <?php if (!empty($profile->public_email)): ?>
                        <li><i class="glyphicon glyphicon-envelope text-muted"></i> <?= Html::a(Html::encode($profile->public_email), 'mailto:' . Html::encode($profile->public_email)) ?></li>
                    <?php endif; ?>
                    <li><i class="glyphicon glyphicon-time text-muted"></i> <?= Yii::t('user', 'Joined on {0, date}', $profile->user->created_at) ?></li>
                </ul>
                <?php if (!empty($profile->bio)): ?>
                    <p><?= Html::encode($profile->bio) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <ul class="list-unstyled video-list-thumbs row">
        <?php
        foreach($model_contents as $model)
        {
            ?>
            <li class="col-lg-3 col-sm-4 col-xs-6">
                <a href="#" title=<?php echo $model->name,'sadasdd';?>>
                    <p style="height: 130px;">
                        <?php echo Html::img('@web/images/video_thumbnail.jpg',['height'=>'140px']); ?>
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
</div>


<!--<div class="container">
    <ul class="list-unstyled video-list-thumbs row">
        <li class="col-lg-3 col-sm-4 col-xs-6">
            <a href="#" title="Claudio Bravo, antes su debut con el Barça en la Liga">
                <img src="http://i.ytimg.com/vi/ZKOtE9DOwGE/mqdefault.jpg" alt="Barca" class="img-responsive" height="130px" />
                <h2>Claudio Bravo, antes su debut con el Barça en la Liga</h2>
                <span class="glyphicon glyphicon-play-circle"></span>
                <span class="duration">03:15</span>
            </a>
        </li>
        <li class="col-lg-3 col-sm-4 col-xs-6">
            <a href="#" title="Claudio Bravo, antes su debut con el Barça en la Liga">
                <img src="http://i.ytimg.com/vi/ZKOtE9DOwGE/mqdefault.jpg" alt="Barca" class="img-responsive" height="130px" />
                <h2>Claudio Bravo, antes su debut con el Barça en la Liga</h2>
                <span class="glyphicon glyphicon-play-circle"></span>
                <span class="duration">03:15</span>
            </a>
        </li>
        <li class="col-lg-3 col-sm-4 col-xs-6">
            <a href="#" title="Claudio Bravo, antes su debut con el Barça en la Liga">
                <img src="http://i.ytimg.com/vi/ZKOtE9DOwGE/mqdefault.jpg" alt="Barca" class="img-responsive" height="130px" />
                <h2>Claudio Bravo, antes su debut con el Barça en la Liga</h2>
                <span class="glyphicon glyphicon-play-circle"></span>
                <span class="duration">03:15</span>
            </a>
        </li>
        <li class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
            <a href="#" title="Claudio Bravo, antes su debut con el Barça en la Liga">
                <img src="http://i.ytimg.com/vi/ZKOtE9DOwGE/mqdefault.jpg" alt="Barca" class="img-responsive" height="130px" />
                <h2>Claudio Bravo, antes su debut con el Barça en la Liga</h2>
                <span class="glyphicon glyphicon-play-circle"></span>
                <span class="duration">03:15</span>
            </a>
        </li>
        <li class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
            <a href="#" title="Claudio Bravo, antes su debut con el Barça en la Liga">
                <img src="http://i.ytimg.com/vi/ZKOtE9DOwGE/mqdefault.jpg" alt="Barca" class="img-responsive" height="130px" />
                <h2>Claudio Bravo, antes su debut con el Barça en la Liga</h2>
                <span class="glyphicon glyphicon-play-circle"></span>
                <span class="duration">03:15</span>
            </a>
        </li>
    </ul>
</div>