<?php

namespace app\controllers;

use Yii;
use app\models\Cliente;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClienteController implements the CRUD actions for Cliente model.
 */
class ClienteController extends ActiveController
{
    public $modelClass = 'app\models\Cliente';



    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'tokenParam' => 'auth_key',
        ];
        return $behaviors;
    }



    //Mostrar os clientes desse instalador
    //retorna os cliente dos instaladores
    //id é o id do instalador
    public function actioncliinsta($id)
    {
        $request = Yii::$app->request;
        if (!$request->isGet) {
            Yii::$app->response->statusCode = 400;
            die();
        }

        $cli_insta = new $this->modelClass;
        $clientes = $cli_insta::find()->select('id,user_id,nome,Telemovel,Nif,Email')->where(["user_id" => $id])->asArray()->all();
        if ($clientes) {
            return json_encode($clientes);
        }
        return json_encode("NUll");
    }

}
