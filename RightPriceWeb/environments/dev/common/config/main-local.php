<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=185.12.116.77:3306;dbname=marcosfe_rightprice',
            'username' => 'marcosfe_rightprice',
            'password' => 'rightprice9',
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
                'host' => 'smtp.mailtrap.io',
                'username' => '0dd44506526d73',
                'password' => '145ba7e63653e9',
                'port' => '2525',
                'encryption' => 'tls',
            ],
        ],
    ],
];
