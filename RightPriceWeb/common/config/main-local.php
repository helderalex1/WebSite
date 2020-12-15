<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=www.marcosferreira.site:3306;dbname=marcosfe_rightprice',
            'username' => 'marcosfe_rightprice',
            'password' => 'marcosfe_rightprice',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mail.marcosferreira.site',
                'username' => 'rightprice@marcosferreira.site',
                'password' => 'rightprice9',
                'encryption' => 'tls',
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // uncomment if you want to cache RBAC items hierarchy
            // 'cache' => 'cache',
        ],
            // ...
    ],
];
