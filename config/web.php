<?php



$params = require(__DIR__ . '/params.php');



$config = [

    'id' => 'basic',

    'basePath' => dirname(__DIR__),

    'bootstrap' => ['log'],

	'modules' => [

		'user' => [

			'class' => 'dektrium\user\Module',

			'enableUnconfirmedLogin' => true,

			'confirmWithin' => 21600,

			'cost' => 12,

			'admins' => ['URNAME']

		],

	],

    'components' => [

        'request' => [

            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation

            'cookieValidationKey' => 'RANDOMKEY',

        ],

        'cache' => [

            'class' => 'yii\caching\FileCache',

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

        /*

        'urlManager' => [

            'enablePrettyUrl' => true,

            'showScriptName' => false,

            'rules' => [

            ],

        ],

        */

    ],

    'params' => $params,

];



if (YII_ENV_DEV) {

    // configuration adjustments for 'dev' environment

    $config['bootstrap'][] = 'debug';

    $config['modules']['debug'] = [

        'class' => 'yii\debug\Module',

        // uncomment the following to add your IP if you are not connecting from localhost.

        'allowedIPs' => ['*'],

    ];



    $config['bootstrap'][] = 'gii';

    $config['modules']['gii'] = [

        'class' => 'yii\gii\Module',

        // uncomment the following to add your IP if you are not connecting from localhost.

        'allowedIPs' => ['*'],

    ];

}



return $config;
