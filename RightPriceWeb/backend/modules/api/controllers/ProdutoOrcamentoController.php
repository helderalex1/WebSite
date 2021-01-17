<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;


class ProdutoOrcamentoController extends ActiveController
{
    public $modelClass = 'common\models\OrcamentoProduto';
    public $modulOrcamento = 'common\models\Orcamento';

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
        //retorna todos os produtos do orcamento pedido
    public function actionProdutosOrcamentos($id_orcamento)
    {
        $request = Yii::$app->request;

        if (!$request->isGet) {
            Yii::$app->response->statusCode = 400;
            throw new \yii\web\BadRequestHttpException("Error method you only have permissions to do get method");
        }

        $ModelOrcamento = new $this->modulOrcamento();
        $Orcamento = $ModelOrcamento::find()->where(["id" => $id_orcamento])->one();

        if ($Orcamento) {
            $produtosorcamentosmodel = new $this->modelClass;
            $List_produtosorcamentos = $produtosorcamentosmodel::find()->where(["orcamento_id"=>$id_orcamento])->asArray()->all();

            if ($List_produtosorcamentos){
                return $List_produtosorcamentos;
            }
            return [["sucesso" => "false", "texto" => "Sem produtos o orcamento"]];
        }else {
            throw new \yii\web\NotFoundHttpException("orcamento id not found or didn't exist!");
        }

    }


     public function actionPutProdutosorcamento($id_orcamento,$id_produto,$novo_valor){
    $request = yii::$app->request;
    if(!$request->isPut){
        Yii::$app->response->statusCode = 400;
           throw new \yii\web\BadRequestHttpException("Error method you only have permissions to do get method");
    } 

    $ModelProduto_Orcamento = new $this->modelClass ();

       $RelacaoExiste = $ModelProduto_Orcamento::find()->select('orcamento_id,produto_id,quantidade')->where(["orcamento_id"=>$id_orcamento,"produto_id"=>$id_produto])->one();
    
        if ($RelacaoExiste) {
              $RelacaoExiste->quantidade=$novo_valor;
              $RelacaoExiste->save();
                return ["sucesso"=>"true","texto"=>"Apagado com sucesso"];
                
            }else {
                return ["sucesso" => "false", "texto" => "Erro desconhecido"];
            }
   }
}
