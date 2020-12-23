<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii;


/**
 * FornecedorInstaladorController implements the CRUD actions for FornecedorInstalador model.
 */
class FornecedorInstaladorController extends ActiveController
{
    public $modelClass = 'common\models\fornecedorinstalador';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'tokenParam' => 'auth_key',
        ];
        return $behaviors;
    }



    //Mostrar os instaladores desse fornecedor
    //retorna os ids dos instaladores desse fornecedor
    //id é o id do fornecedor
    public function actionFornecedorMeusInstaladores($id_fornecedor)
    {

        $request = Yii::$app->request;
        if (!$request->isGet)
        {
            Yii::$app->response->statusCode = 400;
            die();
        }

        $fornecedor_instalador = new $this->modelClass;
        $List_fornecedor = $fornecedor_instalador::find()->select('fornecedor_id,instalador_id')->where(["fornecedor_id"=>$id_fornecedor])->asArray()->all();

        if ($List_fornecedor){
            return json_encode($List_fornecedor);
        }
        return json_encode("NUll");

                                               /* $query = new Query;
                                                $script = ($query
                                                    ->select('f.fornecedor_id, f.instalador_id')
                                                    ->from('fornecedor_instalador f')
                                                    ->where('f.fornecedor_id=' . $id))
                                                    ->createCommand();
                                                $queryResult = $script->queryAll();
                                                return $queryResult;*/
    }


    //Mostrar os fornecedores desse instalador
    //retorna os ids dos fornecedores desse instalador
    //id é o id do instalador
    public function actionInstaladorMeusFornecedores($id_instalador){
       $request = Yii::$app->request;
       if (!$request->isGet)
       {
           Yii::$app->response->statusCode = 400;
           die();
       }

       $instalador_fornecedor = new $this->modelClass;
       $List_instaladores= $instalador_fornecedor::find()->select('fornecedor_id,instalador_id')->where(["instalador_id"=>$id_instalador])->asArray()->all();

       if ($List_instaladores){
           return json_encode($List_instaladores);
       }
       return json_encode("NUll");

                                 /*$query = new Query;
                                 $script = ($query
                                       ->select('u1.*')
                                     ->from('fornecedor_instalador fi')
                                     ->innerJoin('user u','u.id = fi.instalador_id ')
                                     ->innerJoin('user u1','fi.fornecedor_id = u1.id')
                                     ->where('u.id='.$id))
                                     ->createCommand();
                                 $queryResult = $script->query();
                                    return $queryResult;*/
   }
}


