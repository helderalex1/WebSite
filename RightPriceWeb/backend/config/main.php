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
        'api' => [
            'class' => 'app\modules\api\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' =>
                [
                    'application/json' => 'yii\web\JsonParser',
                ]
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
                    'controller' => ['api/utilizador','api/utilizador-token','api/produto','api/fornecedor-instalador','api/categoria','api/cliente','api/orcamento','api/produto-orcamento'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        //contrololador utilizador (Serve para o login e o registar). Não necessita de token a enviar
                        'GET login/{username}{password_hash}' => 'login',
                        'POST registar' =>'registar',

                        //controlador utilizador token (serve para admin carregar utilizadores,instalador carregar os fornecedores e os fornecedores carregar os instaladores)
                        'GET user' =>'user',
                        'GET userinstalador' =>'userinstalador',
                        'GET userfornecedor' =>'userfornecedor',


                        //controlador produto (O ID é o ID do fornecedor)
                        // serve para pedir os produtos do fornecedor
                        'GET produtosfornecedor/{id_fornecedor}'=>'produtosfornecedor',

                        // controlador FornecedorInstalador
                        //Serve para o fornecedor pedir os seus instaladores
                        //id é do fornecedor
                        'GET fornecedor-meus-instaladores/{id_fornecedor}' => 'fornecedormeusinstaladores',
                        //Serve para o instaldor pedir os seus fornecedores
                        //id é o do instalador
                        'GET instalador-meus-fornecedores/{id_instalador}'=>'instaladormeusfornecedores',


                        //controlador das categorias
                        //retorna as categorias do sistema
                        'GET categoria' =>'categoria',

                        //controlador clientes
                        'GET clientesinstalador/{id_instalador}' => 'clientesinstalador',

                        //controlador orcamento
                        //cliente_id é o id do cliente
                        'GET orcamentos/{cliente_id}'=>'orcamentos',

                        //controlador dos produtos do orçamento
                        //id_orcamento é o id do orcamento
                        'GET produtosorcamentos/{id_orcamento}'=>'produtosorcamentos'
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
