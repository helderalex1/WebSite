<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\web\Controller;
use \GuzzleHttp\json_encode;


/**
 * Default controller for the `v1` module
 */
class CategoriaController extends ActiveController
{
    public $modelClass = 'common\models\Categoria';


    public function actionCategoria(){
        $catemodel= new $this->modelClass;

        $categorias= $catemodel::find()->asArray()->all();
        return json_encode($categorias);
    }
}
