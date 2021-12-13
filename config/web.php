<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ]
    ],
    'timezone' => 'Asia/Karachi',
    'language'   => 'en',
    'sourceLanguage' => 'en_US', 
    'components' => [ 
        'common' => [
            'class' => 'app\components\CommonHelper',
        ],
        'feeHelper' => [ 'class' => 'app\components\FeeHelper',],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'po6QwE6_1xiQ14wFp17WnM9pPQLkRYdM',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
            'writeCallback' => function ($session)
            {
                if(!Yii::$app->user->isGuest)
                {
                    return [
                        'user_id' => Yii::$app->user->id,
                        'fk_branch_id' => Yii::$app->user->identity->fk_branch_id
                    ];
                }
                else
                {
                    return false;
                }
            },
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            /*'enableAutoLogin' => false,*/
            'authTimeout'=> 172800,
            'loginUrl' => ['site/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),
         'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => array(
                 /* '<controller:\w+>/<id:\d+>' => '<controller>/view',*/
                  /*'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',*/
                  /*'<controller:\w+>/<action:\w+>' => '<controller>/<action>',*/
                '<alias:index|home|error|login|dashboard|logout|index|signup|request-password-reset|reset-password|check-session>' => 'site/<alias>'
            ),
         ],
    ],
    'as beforeRequest' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'actions' => ['login', 'error'],
                'allow' => true,
            ],
            [

                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
    'params' => $params,
];
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
