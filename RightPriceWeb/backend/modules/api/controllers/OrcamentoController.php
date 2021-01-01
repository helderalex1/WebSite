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
    public function actionOrcamentos(){
        $request = Yii::$app->request;
        if (!$request->isGet) {
            Yii::$app->response->statusCode = 400;
            throw new \yii\web\BadRequestHttpException("Error method you only have permissions to do get method");
        }

        $orcamentomodel= new $this->modelClass;
        $List_orcamentos= $orcamentomodel::find()->asArray()->all();

        if ($List_orcamentos){
            return json_encode($List_orcamentos);
        }
        return json_encode("NUll");
    }
}
