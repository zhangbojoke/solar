<?php
if(explode(".",$_SERVER['HTTP_HOST'])[1] == 'local'){
    $mysqlHost = 'mysql:host=127.0.0.1;dbname=solar';
    $mysqlName = 'root';
    $mysqlPass = 'root';
    $redisHost = '127.0.0.1';
}
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => ['debug','gii'],
    'modules'=>[
        'debug' => [
            'class' => 'yii\debug\Module',
        ],
        'gii'=>[
            'class' => 'yii\gii\Module',
            'allowedIPs'=>['*']
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'solar',
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
        'cookie'=>[
            'class'=>'yii\cookie'
        ],
        'request' => [
            'cookieValidationKey'=>'solar',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'yyyy-MM-dd',
            'decimalSeparator' => '.',
            'thousandSeparator' => ',',
            'currencyCode' => 'CNY',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => $mysqlHost,//'mysql:host=127.0.0.1;dbname=jupai',
            'username' => $mysqlName,
            'password' => $mysqlPass,
            'charset' => 'utf8',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => $redisHost,
            'port' => 6379,
        ],
        'solar'=>[
            'class'=>'common\components\solar\Api',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'module'=>[
                    'pattern'=>'<domain:(\w|-)+>/<controller:(\w|-)+>/<action:(\w|-)+>',
                    'route'=>'<controller>/<action>',
                    'mode'=>'<domain>',
                ],
            ],
        ],
    ],
];
