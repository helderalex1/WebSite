<?php

namespace app\controllers;

use Yii;
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
    public $modelClass = 'app\models\Produto';

    //Total produtos
    public function actionTotal(){
        $model = new $this->modelClass;
        $ret = $model::find()->all();
        return['total'=>count($ret)];
    }

    //Instalador produtos do seu fornecedor
    public function actionProdutoforne($id){
        $query = new Query;
        $script = ($query
            ->select('p.*')
            ->from('user u')
            ->innerJoin('fornecedor_instalador fi','fi.fornecedor_id = u.id')
            ->innerJoin('user u1','u1.id = fi.instalador_id ')
            ->innerJoin('produto p', 'p.fornecedor_id=u1.id')
            ->where('u.id='.$id.' AND u.categoria_id <=> u1.categoria_id'))
            ->createCommand();
        $queryResult = $script->query();
        return $queryResult;
    }
}
