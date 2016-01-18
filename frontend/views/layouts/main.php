<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use Yii;
/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap" style="background-color: rgba(206, 211, 226, 0.47)">
        <?php
            NavBar::begin([
                'brandLabel' => '<i id="icon" class="fa fa-laptop" style="margin-top:-22px;text-shadow: rgb(55, 125, 179) 0px 0px 0px, rgb(58, 132, 188) 1px 1px 0px, rgb(61, 139, 198) 2px 2px 0px, rgb(64, 145, 207) 3px 3px 0px, rgb(67, 152, 217) 4px 4px 0px, rgb(70, 159, 226) 5px 5px 0px, rgb(73, 166, 236) 6px 6px 0px, rgb(76, 172, 245) 7px 7px 0px; font-size: 43px; color: rgb(0, 0, 0); height: 56px; width: 56px; line-height: 56px; border-radius: 49%; text-align: center; background-color: rgb(79, 179, 255);"></i>  Paathsaala',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar default-color navbar-fixed-top',
                    'style'=>'z-index:11;'
                ],
            ]);
        $navItems=[
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Profile', 'url' => ['/user/profile']],
            ['label' => 'Search', 'url' => ['/university/index']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            ['label'=>'Notifications'.Html::tag('span', '10', ['class' => 'label-danger']), 'url'=>['/site/contact']],
        ];
        if (Yii::$app->user->isGuest) {
            array_push($navItems,['label' => 'Sign In', 'url' => ['/user/security/login']],['label' => 'Sign Up', 'url' => ['/user/registration/register']]);
        } else {
            array_push($navItems,['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/user/security/logout'],
                    'linkOptions' => ['data-method' => 'post']]
            );
        }
        echo Nav::widget([
            'encodeLabels' => false,
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $navItems,
        ]);
            NavBar::end();
        ?>

        <div class="container row">
            <div class="col-md-10" style="margin-top: 1.3%;">
                <?= $content ?>
            </div>
            <div class="col-md-2" style="margin-top: 5.4%;position: fixed;margin-left: 74%;">
                <?php
                   echo $this->render('//site/_suggestions');
                ?>
                <?php
                ?>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; Paathsaala <?= date('Y') ?></p>\
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
