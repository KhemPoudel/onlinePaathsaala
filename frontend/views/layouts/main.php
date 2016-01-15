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
                    'class' => 'navbar navbar-inverse navbar-fixed-top',
                ],
            ]);
        $navItems=[
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Profile', 'url' => ['/user/profile']],
            ['label' => 'Search', 'url' => ['/university/index']],
            ['label' => 'Contact', 'url' => ['/site/contact']]
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
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $navItems,
        ]);
            NavBar::end();
        ?>

        <div class="container row">
            <div class="col-md-9 pull-left" style="margin-top: 4%;">
                <?= $content ?>
            </div>
            <div class="col-md-3 pull-right" style="margin-top: 4%;">
                <?php if(isset($this->blocks['suggestion_block']))
                {
                    echo $this->blocks['suggestion_block'];
                }
                else
                {
                  echo 'fuck';
                }
                ?>
                <div>
                    <h5>sadad</h5>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
