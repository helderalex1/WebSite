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
                    'controller' => ['v1/Utilizador','v1/Utilizador-token','v1/produto','v1/fornecedor-instalador','v1/categoria','v1/cliente','v1/orcamento','v1/Produto-orcamento'],
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
                        'GET orcamentos'=>'orcamentos',

                        //controlador dos produtos do orçamento
                        'GET produtosorcamentos'=>'produtosorcamentos'
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
