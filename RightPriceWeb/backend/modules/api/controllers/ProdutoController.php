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
    public $modelAuthAssigment= 'common\models\AuthAssignment';

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
    //serve para quando o fornecedor pedir os seus produtos e o instalador pedir os produtos dos fornecedores
    public function actionProdutosFornecedor($id_fornecedor){
        $request = Yii::$app->request;
        if (!$request->isGet)
        {
            Yii::$app->response->statusCode = 400;
            throw new \yii\web\BadRequestHttpException("Error method you only have permissions to do get method");
        }

        $ModelAuth_Assignment = new $this->modelAuthAssigment ();
        $FornecedorExiste = $ModelAuth_Assignment::find()->where(["user_id" => $id_fornecedor])->one();

        if ($FornecedorExiste) {
            if (strcmp($FornecedorExiste->item_name, "fornecedor")==0) {
                $ModelProduto = new $this->modelClass;
                $List_produtos = $ModelProduto::find()->select('id,fornecedor_id,imagem,nome,referencia,descricao,preco')->where(["fornecedor_id"=>$id_fornecedor])->asArray()->all();

                if ($List_produtos){
                    return $List_produtos;
                }else{
                    return ["sucesso" => "false", "texto" => "Sem produtos"];
                }
            }else {
                throw new \yii\web\NotFoundHttpException("Fornecedor id not found or didn't exist!");
            }
        }else{
            throw new \yii\web\NotFoundHttpException("Fornecedor id not found or didn't exist!");
        }
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
