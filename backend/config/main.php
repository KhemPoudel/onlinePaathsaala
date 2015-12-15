<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    //'modules' => [],
    'components' => [
        //'user' => [
          //  'identityClass' => 'common\models\User',
            //'enableAutoLogin' => true,
        //],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            //'class' => 'dektrium\user\Module',
            'modelMap' => [
                'User' => 'backend\models\User',
            ],
            //'as backend' => 'dektrium\user\filters\BackendFilter',
            //'controllers' => ['profile', 'recovery', 'registration', 'settings'],
        ],
    ],
    'params' => $params,
];
