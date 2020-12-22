<?php

namespace app\modules\v1\controllers;

use Yii;
    use yii\filters\auth\QueryParamAuth;
use app\models\Produto;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
    public function actionProdutosforne($id){
        $request = Yii::$app->request;
        if (!$request->isGet)
        {
            Yii::$app->response->statusCode = 400;
            die();
        }
        $ModelProduto = new $this->modelClass;
        $List_produtos = $ModelProduto::find()->select('id,imagem,nome,referencia,descricao,preco')->where(["fornecedor_id"=>$id])->asArray()->all();
        if ($List_produtos){
            return json_encode($List_produtos);
        }
        return json_encode("NUll");

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
