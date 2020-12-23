<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;


/**
 * ProdutoController implements the CRUD actions for Produto model.
 */
class ProdutoController extends ActiveController
{
    public $modelClass = 'common\models\Produto';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'tokenParam' => 'auth_key',
        ];
        return $behaviors;
    }


    //Produtos do Fornecedor (id do fornecedor)
    //serve para quando o fornecedor pedir os seus produtos
    public function actionProdutosFornecedor($id_fornecedor){
        $request = Yii::$app->request;
        if (!$request->isGet)
        {
            Yii::$app->response->statusCode = 400;
            die();
        }

        $ModelProduto = new $this->modelClass;
        $List_produtos = $ModelProduto::find()->select('id,imagem,nome,referencia,descricao,preco')->where(["fornecedor_id"=>$id_fornecedor])->asArray()->all();

        if ($List_produtos){
            return json_encode($List_produtos);
        }
        return json_encode("NUll");

                                    //diferente forma de fazer a query

                                   /* $query = new Query;
                                    $script = ($query
                                        ->select('p.id,p.imagem,p.nome,p.referencia,p.descricao,p.preco')
                                        ->from('produto p')
                                        ->where('p.fornecedor_id='.$id))
                                        ->createCommand();
                                    $queryResult = $script->query();
                                    return $queryResult;*/
    }
}
