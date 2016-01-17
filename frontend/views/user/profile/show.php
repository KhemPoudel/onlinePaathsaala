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
?>
<div class="">
        <div class="col-md-3" style="margin-right: -5%;">
            <!--/. SideNav slide-out button -->

            <!-- Sidebar navigation -->
            <ul id="slide-out" class="side-nav fixed" style="margin-top: 7%;margin-bottom: 7%;z-index:1;">

            <!-- Logo -->
            <a href="#" class="waves-effect waves-light avatar-wrapper" style="background-image: url('http://localhost/onlinePaathsaala/frontend/web/images/logo-bg.jpg');)">
                <img src="http://localhost/onlinePaathsaala/frontend/web/images/video_thumbnail.jpg" style="text-shadow: none; font-size: 80px; color: rgb(255, 255, 255); height: 107px; width: 107px; line-height: 107px; border-radius: 50%; text-align: center; background-color: rgb(16, 36, 51);">
            </a>
            <!--/. Logo -->

            <div class="about-me text-center">
                <p>
                    <?php if(!empty($profile->bio)):?>
                        <?php //Html::encode($profile->bio);
                        echo 'dasddd';?>
                    <?php endif;?>
                    <?php if(empty($profile->bio)):?>
                        <span class="text-center"> Bio Not Available</span>
                    <?php endif;?>
                </p>
            </div>
            <!--Social icons-->
            <div class="social-sec">
                <ul class="list-inline text-center">
                    <li><a class="btn-floating btn-small fb-bg waves-effect waves-light"><i class="fa fa-facebook"> </i></a></li>
                    <li><a class="btn-floating btn-small tw-bg waves-effect waves-light"><i class="fa fa-twitter"> </i></a></li>
                    <li><a class="btn-floating btn-small gplus-bg waves-effect waves-light"><i class="fa fa-google-plus"> </i></a></li>
                </ul>
            </div>
            <!--/.Social icons-->

            <!-- AboutMe -->
            <div class="cat-title">
                <h6>Categories:</h6>
            </div>
            <!--/. AboutMe -->

            <!-- Side navigation links -->
            <ul class="collapsible collapsible-accordion">
                <li><a class="collapsible-header waves-effect active">Contents</a>
                </li>

                <li><a class="collapsible-header waves-effect" id="wishlist">WishList</a>
                </li>

                <!--<li><a class="collapsible-header waves-effect">Dropdown menu</a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="#">Link</a>
                            </li>
                            <li><a href="#">Link</a>
                            </li>
                            <li><a href="#">Link</a>
                            </li>
                            <li><a href="#">Link</a>
                            </li>
                        </ul>
                    </div>
                </li>-->
            </ul>
            <!--/. Side navigation links -->
        </div>
        <div class="col-md-9 pull-right" style="margin-left:-5%;">
            <div class="card-panel author-box hoverable">

                <div class="row center-on-small-only">
                    <!--Avatar-->
                    <div class="col-sm-3 ">
                        <?=Html::img('@web/images/khem.jpg',['class'=>'img-responsive','style'=>"text-shadow: none; font-size: 80px; color: rgb(255, 255, 255); height: 136px; width: 136px; line-height: 136px; border-radius: 50%; text-align: center; background-color: rgb(12, 27, 38);"])?>
                    </div>
                    <!--/.Avatar-->

                    <!--Content-->
                    <div class="col-sm-9">
                        <h5 class="author-name"><?= Html::encode($profile->user->username)?></h5>

                        <div class="personal-sm">
                            <a class="icons-sm email-ic"><i class="fa fa-home"> </i></a>
                            <a class="icons-sm fb-ic"><i class="fa fa-facebook"> </i></a>
                            <a class="icons-sm tw-ic"><i class="fa fa-twitter"> </i></a>
                            <a class="icons-sm gplus-ic"><i class="fa fa-google-plus"> </i></a>
                            <a class="icons-sm li-ic"><i class="fa fa-linkedin"> </i></a>
                            <a class="icons-sm email-ic"><i class="fa fa-envelope-o"> </i></a>
                        </div>
                        <br>
                        <!--Description-->
                        <p class="author-description">
                            <?= Html::encode($profile->bio) ?>
                        </p>
                        <!--/.Description-->
                    </div>
                    <!--Content-->
                </div>
                <hr>
                <div class="row center-on-small-only">
                    <div class="col-sm-6">
                        <p>
                            <strong class="col-sm-6">
                                <?= Html::a($follower->count(), ['/follow/followers','id'=>$id])?>
                                <small>
                                    Followers
                                </small>
                            </strong>
                            <strong class="col-sm-6">
                                <?= Html::a($following->count(), ['/follow/followings','id'=>$id])?>
                                <small> Followings</small>
                            </strong>
                        </p>
                        <?php
                        $profile_btn_class='';
                        if ($id!=\Yii::$app->user->identity->getId()):
                            $profile_btn_class='hidden';
                        endif; ?>
                        <a href="<?php echo Url::toRoute('/user/admin/updatefromuser').'?id='. $id;?>">
                            <button class="btn btn-border-info btn-block <?= $profile_btn_class?>"><span class="fa fa-user"></span> View Profile </button>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <p>
                            <strong>
                                <?= Html::a($followed_programs->count(), ['/follow/followedprograms','id'=>$id])?>
                                <small> Programs</small>
                            </strong>
                        </p>
                        <?php
                        $follow_btn_class='';
                        if ($id==\Yii::$app->user->identity->getId()):
                            $follow_btn_class='';
                        endif; ?>
                        <button style="margin-top: -3.1%;" class="btn btn-border-success btn-block <?= $follow_btn_class?>"><span class="fa fa-plus-circle"></span> Follow </button>
                    </div>
                </div>
            </div>
            <!--/.Author box-->
            <hr>
            <hr>
            <div class="card-panel bl-panel text-center hoverable" style="margin-left: 0%;margin-right: 0%;">
                <ul class="nav nav-tabs tabs-3" style="
                                                position: relative;
                                                height: 48px;
                                                background-color: #fff;
                                                margin: 0 auto;
                                                width: 100%;
                                                white-space: nowrap;
                                                border: none;
                                                border-bottom: 1px solid #ddd;
                                                padding-left: 0;
                                                padding: 0;
                                                list-style: none;
                                                box-shadow: 0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <li style="
                        width: 33%;
                        display: block;
                        float: left;
                        text-align: center;
                        line-height: 48px;
                        height: 48px;
                        padding: 0;
                        margin: 0;
                        text-transform: uppercase;
                        letter-spacing: .8px;" class="active">
                        <a data-toggle="tab" href="#video-tab">Videos</a>
                    </li>
                    <li style="
                        width: 33%;
                        display: block;
                        float: left;
                        text-align: center;
                        line-height: 48px;
                        height: 48px;
                        padding: 0;
                        margin: 0;
                        text-transform: uppercase;
                        letter-spacing: .8px;">
                        <a data-toggle="tab" href="#pdf-tab">Pdfs</a>
                    </li>
                    <li style="
                        width: 33%;
                        display: block;
                        float: left;
                        text-align: center;
                        line-height: 48px;
                        height: 48px;
                        padding: 0;
                        margin: 0;
                        text-transform: uppercase;
                        letter-spacing: .8px;">
                        <a data-toggle="tab" href="#img-tab">Images</a>
                    </li>
                </ul>
                <div class="tab-content" >
                    <?= $this->render('_profileContents',['model_videos'=>$model_videos,'model_pdf'=>$model_pdf,'model_img'=>$model_img])?>
                </div>
            </div>
        </div>
</div>



<?php
$js = <<<JS
    $('#wishlist').on('click',function(){
       //alert('ok');
       $(".tab-content").html('<img src="http://localhost/onlinePaathsaala/frontend/web/images/loader1.gif">');
       $.get("profile/getwishlist", function(data)
       {
        $(".tab-content").html(data);
       });
    });
JS;
$this->registerJs($js);
