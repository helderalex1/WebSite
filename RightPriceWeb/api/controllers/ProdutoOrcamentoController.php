<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;


class ProdutoOrcamentoController extends ActiveController
{
    public $modelClass = 'app\models\OrcamentoProduto';

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
        public function actionProduOrcamento()
    {
        $catemodel = new $this->modelClass;

        $prcamentos = $catemodel::find()->asArray()->all();
        return json_encode($prcamentos);
    }



}
