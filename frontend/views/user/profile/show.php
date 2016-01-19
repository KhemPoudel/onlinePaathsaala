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
use kartik\widgets\FileInput;

/**
 * @var \yii\web\View $this
 * @var \dektrium\user\models\Profile $profile
 */

$this->title = empty($profile->name) ? Html::encode($profile->user->username) : Html::encode($profile->user->username);
?>
<div class="">
        <div class="col-md-3" style="margin-right: -5%;">
            <!--/. SideNav slide-out button -->

            <!-- Sidebar navigation -->
            <ul id="slide-out" class="side-nav fixed" style="margin-top: 7%;margin-bottom: 7%;z-index:1;">

            <!-- Logo -->
            <a href="#" class="waves-effect waves-light avatar-wrapper" style="background-image: url('http://localhost/onlinePaathsaala/frontend/web/images/logo-bg.jpg');)">

            </a>
            <!--/. Logo -->

            <div class="about-me text-center">
                <p id="about">
                    <?php if(!empty($profile->bio)):?>
                        <p>
                            <?=$profile->bio?>

                        </p>
                    <?php endif;?>
                    <?php if(empty($profile->bio)):?>
                        <span class="text-center"> Bio Not Available</span>
                    <?php endif;?>
                </p>
            </div>
                <?php if($profile->user->id==\Yii::$app->user->identity->getId()):?>
                    <div class="social-sec">
                        <p id="">
                            <i class="fa fa-edit" id="edit-bio"></i>
                            <i class="fa fa-close" id="close-bio"></i>
                            <i class="fa fa-upload" id="submit-bio"></i>
                        </p>
                    </div>
                <?php endif;?>
                <div class="social-sec">
                    <p id="edit-box">

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

                <li><a class="collapsible-header waves-effect" data-id="<?=\Yii::$app->user->identity->getId()?>" id="wishlist">WishList</a>
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
                        <?=Html::img('@web/images/'.$profile->name,['class'=>'img-responsive','style'=>"text-shadow: none; font-size: 80px; color: rgb(255, 255, 255); height: 136px; width: 136px; line-height: 136px; border-radius: 50%; text-align: center; background-color: rgb(12, 27, 38);",'data-toggle'=>'modal' ,'data-target'=>'#myModal'])?>
                    </div>
                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Upload Profile Picture</h4>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    echo FileInput::widget([
                                        'name'=>'file',
                                        'options'=>[
                                            'multiple'=>true,
                                        ],
                                        'pluginOptions'=>[
                                            'uploadUrl'=>\yii\helpers\Url::to('/onlinePaathsaala/frontend/web/index.php/user/admin/updatefromuser')
                                        ]
                                    ]);
                                    ?>
                                </div>
                            </div>

                        </div>
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
                    </div>
                    <div class="col-sm-6">
                        <p>
                            <strong class="col-sm-6">
                                <?= Html::a($followed_programs->count(), ['/follow/followedprograms','id'=>$id])?>
                                <small> Programs</small>
                            </strong>
                        </p>

                        <?php
                        $follow_status='Unfollow';
                        $btn_follow='<i class="fa fa-minus-circle"></i>  Unfollow';
                        $follow_btn_class='';
                        if(count(\common\models\FollowerUsertoUser::find()->where(['followed_user_id'=>$id,'follower_user_id'=>\Yii::$app->user->identity->getId()])->all())==0) {
                            $follow_status = 'Follow';
                            $btn_follow='<i class="fa fa-user-plus"></i>  Follow';
                        }
                        if ($id==\Yii::$app->user->identity->getId())
                            $follow_btn_class='disabled';
                        ?>
                        <p class="col-sm-6">
                            <button type="button" style="margin-top: -11%;margin-left:-22px;" class="btn btn-border-success btn-follow <?=$follow_btn_class?>" id="<?php echo $id?>" data-id="<?php echo $id?>" data-follow-status="<?php echo $follow_status?>">
                                <span id="span-<?php echo $id;?>"><?= $btn_follow?></span>
                            </button>
                        </p>

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
                <div class="tab-content" id="tab-content-<?=\Yii::$app->user->identity->getId()?>">
                    <?= $this->render('_profileContents',['model_videos'=>$model_videos,'model_pdf'=>$model_pdf,'model_img'=>$model_img])?>
                </div>
            </div>
        </div>
</div>



<?php
$js = <<<JS
    $('#wishlist').on('click',function(){
       //alert('ok');
       var id=$(this).attr('data-id');
       alert(id);
       $("#tab-content-"+id).html('<img src="http://localhost/onlinePaathsaala/frontend/web/images/loader1.gif">');
       $.get("profile/getwishlist", function(data)
       {
        $("#tab-content-"+id).html(data);
       });
    });
    $('.btn-follow').on('click', function(e) {
            e.preventDefault();
            var id=$(this).attr('data-id');
            var follow_status=$(this).attr('data-follow-status');
            var data = {'followed_id':id,'follow_status':follow_status};
            alert(id);
            $.ajax({
                url:'/onlinePaathsaala/frontend/web/index.php/follow/addfollower',
                dataType:"json",
                type:'post',
                data: data,
                success: function(response) {
                    console.log(response);
                    if(response>=0)
                    {
                    if(response=='0')
                    {
                        $('#span-'+id).html('<i class="fa fa-minus-circle"></i> Unfollow');
                        $('#'+id).attr('data-follow-status','Unfollow');
                    }

                    else{
                            $('#span-'+id).html('<i class="fa fa-user-plus"></i> Follow');
                            $('#'+id).attr('data-follow-status','Follow');
                    }
                    }
                },
                error: function(xhr,status,err){
                console.log(status);
                console.log(err);
                }
            });
    });
    $('#edit-bio').on('click',function(){
        $('#edit-box').html('<textarea id="bio-box"></textarea>');
    });
    $('#close-bio').on('click',function(){
        $('#edit-box').html('asd');
    });
    $('#submit-bio').on('click',function(){
        var bio=$('#bio-box').val();
        var data={'bio':bio};
        $.ajax({
        url:'/onlinePaathsaala/frontend/web/index.php/user/profile/addbio',
        dataType:"json",
        type:'post',
        data: data,
        success:function(response){
                ('#about').html('asdad');
        }
        });
    });
JS;
$this->registerJs($js);
