<?php

namespace app\modules\api\controllers;

use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;


/**
 * OrcamentoController implements the CRUD actions for Orcamento model.
 */
class OrcamentoController extends ActiveController
{
    public $modelClass = 'common\models\orcamento';
    public $modelCliente = 'common\models\cliente';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'tokenParam' => 'auth_key',
        ];
        return $behaviors;
    }


    //função que vai buscar os orcamnetos
    //retorna todos os orçamentos do sistema
    public function actionOrcamentos($cliente_id){
        $request = Yii::$app->request;
        if (!$request->isGet) {
            Yii::$app->response->statusCode = 400;
            throw new \yii\web\BadRequestHttpException("Error method you only have permissions to do get method");
        }

        $ModelCliente = new $this->modelCliente ();
        $cliente = $ModelCliente::find()->where(["id" => $cliente_id])->one();

        if ($cliente) {
            $orcamentomodel= new $this->modelClass;
            $List_orcamentos= $orcamentomodel::find()->where(["cliente_id"=>$cliente_id])->asArray()->all();

            if ($List_orcamentos){
                return $List_orcamentos;
            }else {
                return ["sucesso" => "false", "texto" => "Sem orcamentos"];
            }
        }else {
            throw new \yii\web\NotFoundHttpException("Cliente id not found or didn't exist!");
        }

    }
}
