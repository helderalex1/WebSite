<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;



/**
 * ClienteController implements the CRUD actions for Cliente model.
 */
class ClienteController extends ActiveController
{

    public $modelClass = 'common\models\Cliente';


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
    public function actionClientesInstalador($id_instalador)
    {
        $request = Yii::$app->request;
        if (!$request->isGet) {
            Yii::$app->response->statusCode = 400;
            die();
        }

        $clientes_insta = new $this->modelClass;
        $List_clientes = $clientes_insta::find()->select('id,user_id,nome,Telemovel,Nif,Email')->where(["user_id" => $id_instalador])->asArray()->all();

        if ($List_clientes) {
            return json_encode($List_clientes);
        }
        return json_encode("NUll");
    }

}
