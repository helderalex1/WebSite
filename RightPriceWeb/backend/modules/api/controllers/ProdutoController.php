<?php

namespace app\modules\api\controllers;

use common\models\FornecedorInstalador;
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
            throw new \yii\web\BadRequestHttpException("Error method you only have permissions to do get method");
        }

        $ModelProduto = new $this->modelClass;
        $List_produtos = $ModelProduto::find()->select('id,imagem,nome,referencia,descricao,preco')->where(["fornecedor_id"=>$id_fornecedor])->asArray()->all();
        $ModelFornecedorInstalador = new FornecedorInstalador();
        $FornecedorExiste = $ModelFornecedorInstalador::find()->select('fornecedor_id')->where(["fornecedor_id"=>$id_fornecedor])->asArray()->one();
        if ($List_produtos and $FornecedorExiste){
            return json_encode($List_produtos);
        }else if($FornecedorExiste){
            return json_encode("Null");
        }
        throw new \yii\web\NotFoundHttpException("Provider id not found or didn't exist!");

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
