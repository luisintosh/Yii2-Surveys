<?php

$params = require(__DIR__ . '/params.php');
/* Include debug functions */
require_once(__DIR__.'/functions.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log','timezone'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'S0xIAuCtIi7wfVQsj22bN2pQOO2Uvnjb',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'app\modules\user\components\User',
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail/layouts/html',
            'useFileTransport' => false,
            'transport' => require(__DIR__ . '/mailer.php'),
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
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        'settings' => [
          'class' => 'app\components\SettingsComponent',
        ],
        'timezone' => [
            'class' => 'yii2mod\timezone\Timezone',
            'actionRoute' => '/site/timezone'
        ],
    ],
    'params' => $params,
    'modules' => [
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to  
            // use your own export download action or custom translation 
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
