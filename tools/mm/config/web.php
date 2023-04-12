<?php

$config = [
    'id' => B3P_TOOL_MM_ID,
    'basePath' => dirname(__DIR__),
    'bootstrap' => [],//['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => B3P_TOOL_MM_COOKIE_VALIDATION_KEY,
        ],
        /*'cache' => [
            'class' => 'yii\caching\FileCache',
        ],*/
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'api/mmedia/<action>' => 'mm/api/<action>'
            ],
        ],
        'fs' => [
            'class' => B3P_TOOL_MM_FILE_MANAGER_UPLOAD_HELPER_CLASS,
            'path' => B3P_TOOL_MM_FILE_MANAGER_PATH,
        ],
    ],
    'modules' => [
        'mm' => [
            'class' => 'iutbay\yii2\mm\Module',
                   'fsComponent' => 'fs',
                   'apiOptions' => [
                       'cors' => [
                           'Origin' => ['*'],
                           'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                           'Access-Control-Request-Headers' => ['*'],
                           'Access-Control-Allow-Credentials' => null,
                           'Access-Control-Max-Age' => B3P_TOOL_MM_ACCESS_CONTROL_MAX_AGE,
                           'Access-Control-Expose-Headers' => [],
                       ],
                   ],
           'thumbsPath' => B3P_TOOL_MM_FILE_MANAGER_THUMB_DIR,
           'thumbsUrl' => B3P_TOOL_MM_FILE_MANAGER_THUMB_DIR,
           'thumbsSize' => B3P_TOOL_MM_FILE_MANAGER_THUMB_SIZE,
        ],
    ],
];
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1','127.0.0.1:8000','localhost:8000', '::1'],
    ];
}
return $config;
