<?php

namespace app\controllers;

use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;



//não vamos utilizar

class CategoriasTokenController extends ActiveController
{
    public $modelClass = 'app\models\Categoria';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }
}
