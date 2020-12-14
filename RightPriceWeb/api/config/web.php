<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'pbre6vODj8kUE6F3kiBryLpdbvE6drh0',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]

        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
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
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['Utilizador','Utilizador-token','produto','fornecedor-instalador','categoria-token','categoria',],
                    'pluralize' => false,
                    'extraPatterns' => [
                        //contrololador utilizador
                        'GET login/{username}{password_hash}' => 'login',
                        'POST Registar' =>'Registar',
                        //controlador utilizador token (serve para admin carregar utilizadores)
                        'GET user' =>'User',
                        //controlador produto (O ID é o ID do fornecedor)
                        // serve para pedir os produtos do fornecedor
                        'GET produtosforne/{id}'=>'produtosforne',
                        // controlador FornecedorInstalador
                        //Serve para o fornecedor pedir os seus instaladores
                        //id é do fornecedor
                        'GET forne/{id}' => 'forne',

                        'GET conhecerforne/{id}' => 'conhecerforne',
                        'GET conhecerinsta/{id}' => 'conhecerinsta',

                        'GET insta/{id}' => 'insta',

                        'GET Categoria' =>'Categoria',

                        //'GET users' =>'Users'
                    ],

        ],
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
