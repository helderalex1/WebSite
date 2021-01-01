<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;


class ProdutoOrcamentoController extends ActiveController
{
    public $modelClass = 'common\models\OrcamentoProduto';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'tokenParam' => 'auth_key',
        ];
        return $behaviors;
    }


        //função que vai buscar as os produtos do orçamento
        //retorna todos os produtos de todos os orcamentos do sistema
    public function actionProdutosOrcamentos()
    {
        $request = Yii::$app->request;

        if (!$request->isGet) {
            Yii::$app->response->statusCode = 400;
            throw new \yii\web\BadRequestHttpException("Error method you only have permissions to do get method");
        }

        $produtosorcamentosmodel = new $this->modelClass;
        $List_produtosorcamentos = $produtosorcamentosmodel::find()->asArray()->all();

        if ($List_produtosorcamentos){
            return json_encode($List_produtosorcamentos);
        }
        return json_encode("NUll");
    }
}
