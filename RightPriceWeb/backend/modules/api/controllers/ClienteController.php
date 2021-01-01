<?php

namespace app\modules\api\controllers;

use common\models\FornecedorInstalador;
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
            throw new \yii\web\BadRequestHttpException("Error method you only have permissions to do get method");
        }

        $clientes_insta = new $this->modelClass;
        $List_clientes = $clientes_insta::find()->select('id,user_id,nome,Telemovel,Nif,Email')->where(["user_id" => $id_instalador])->asArray()->all();
        $ModelFornecedorInstalador = new FornecedorInstalador();
        $InstaladorExiste = $ModelFornecedorInstalador::find()->select('fornecedor_id')->where(["instalador_id"=>$id_instalador])->asArray()->one();
        if ($List_clientes and $InstaladorExiste) {
            return json_encode($List_clientes);
        }else if($InstaladorExiste){
            return json_encode("NUll");
        }
        throw new \yii\web\NotFoundHttpException("Installer id not found or didn't exist!");
    }

}
