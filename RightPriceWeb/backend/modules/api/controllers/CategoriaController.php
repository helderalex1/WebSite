<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use \GuzzleHttp\json_encode;


/**
 * CategoriaController implements the CRUD actions for Categorias model.
 */

class CategoriaController extends ActiveController
{
    public $modelClass = 'common\models\Categoria';

    //funcao que retorna as categorias do sistema
    public function actionCategoria(){
        $request = Yii::$app->request;
        if (!$request->isGet) {
            Yii::$app->response->statusCode = 400;
            throw new \yii\web\BadRequestHttpException("Error method you only have permissions to do get method");
        }

        $categoriasmodel= new $this->modelClass;
        $List_categorias= $categoriasmodel::find()->asArray()->all();

        if ($List_categorias) {
            return $List_categorias;
        }
        return ["sucesso"=>"false","texto"=>"Sem categorias"];
    }
}
