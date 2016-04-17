<?php

$params = require(__DIR__ . '/params.php');
/* Include debug functions */
require_once(__DIR__.'/functions.php');
/* Include configuration file */
function settings($key) {
    $settings = json_decode(file_get_contents(__DIR__.'/settings.json'), true);
    return $settings[$key];
}


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
            'viewPath' => '@app/mail',
            'useFileTransport' => false,
            'messageConfig' => [
                'from' => [settings('mailer')['username'] => settings('website_title')], // this is needed for sending emails
                'charset' => 'UTF-8',
            ],
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => settings('mailer')['mail_server'],
                'username' => settings('mailer')['username'],
                'password' => settings('mailer')['password'],
                'port' => settings('mailer')['port'],
                'encryption' => 'tls',
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
        'db' => settings('db'),
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
