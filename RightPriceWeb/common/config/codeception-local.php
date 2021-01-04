<?php

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/main.php',
    require __DIR__ . '/main-local.php',
    require __DIR__ . '/test.php',
    require __DIR__ . '/test-local.php',
    [
        'id' => 'app-tests',
        'components' => [
            'request' => [
                // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
                'cookieValidationKey' => 'MO76VFZW2bsHu0b1ciPznYAhlPbR41o3',
            ],
            'db' => [
                'dsn' => 'mysql:host=www.marcosferreira.site:3306;dbname=marcosfe_test',
                'username' => 'marcosfe_test',
                'password' => 'rightprice_test',
                'charset' => 'utf8',
            ]
        ],
    ]
);
