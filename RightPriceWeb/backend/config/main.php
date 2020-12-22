<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'class' => 'app\modules\v1\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/categoria','v1/cliente','v1/Utilizador','v1/Utilizador-token','v1/produto','v1/fornecedor-instalador','v1/Produto-orcamento','v1/orcamento'],
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
                        'GET insta/{id}'=>'Insta',


                        //controlador das categorias
                        //retorna as categorias todas
                        'GET categoria' =>'categoria',

                        //controlador clientes
                        'GET clientes/{id}' => 'cliinsta',

                        //controlador orcamento
                        'GET orcamento'=>'orcamento',

                        //controlador dos produtos do orçamento
                        'GET prodorcamento'=>'ProduOrcamento'
                    ],
                ],
            ],
        ],

    ],
    'params' => $params,
];
