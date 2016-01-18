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
        'brandLabel' => 'Paathsaala',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-inverse navbar-fixed-top',
        ],
    ]);
    $navItems=[
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

    <div class="container">

        <?= Alert::widget() ?>
        <div style="margin-top: 4%;">
            <?= $content ?>
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
