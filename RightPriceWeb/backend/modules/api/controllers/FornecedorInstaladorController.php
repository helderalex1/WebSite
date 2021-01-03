<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii;


/**
 * FornecedorInstaladorController implements the CRUD actions for FornecedorInstalador model.
 */
class FornecedorInstaladorController extends ActiveController
{
    public $modelClass = 'common\models\fornecedorinstalador';
    public $modelAuthAssigment = 'common\models\AuthAssignment';

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
        $ModelAuth_Assignment = new $this->modelAuthAssigment ();
        $FornecedorExiste = $ModelAuth_Assignment::find()->where(["user_id" => $id_fornecedor])->one();

        if ($FornecedorExiste and strcmp($FornecedorExiste->item_name, "fornecedor")==0) {

            $fornecedor_instalador = new $this->modelClass;
            $List_fornecedor = $fornecedor_instalador::find()->select('fornecedor_id,instalador_id')->where(["fornecedor_id"=>$id_fornecedor])->asArray()->all();

            if ($List_fornecedor){
                return $List_fornecedor;
            }else {
                return ["sucesso" => "false", "texto" => "Sem instaladores"];
            }

        }else{
                throw new \yii\web\NotFoundHttpException("Fornecedor id not found or didn't exist!");
        }

        //throw new \yii\web\NotFoundHttpException("Provider id not found or didn't exist!");

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
           throw new \yii\web\BadRequestHttpException("Error method you only have permissions to do get method");
       }
        $ModelAuth_Assignment = new $this->modelAuthAssigment ();
        $InstaladorExiste = $ModelAuth_Assignment::find()->where(["user_id" => $id_instalador])->one();

        if ($InstaladorExiste && strcmp($InstaladorExiste->item_name, "instalador")==0) {
            $instalador_fornecedor = new $this->modelClass;
            $List_instaladores= $instalador_fornecedor::find()->select('fornecedor_id,instalador_id')->where(["instalador_id"=>$id_instalador])->asArray()->all();

            if ($List_instaladores){
                return $List_instaladores;
            }else {
                return ["sucesso" => "false", "texto" => "Sem fornecedores"];
            }
        }else{
            throw new \yii\web\NotFoundHttpException("Instalador id not found or didn't exist!");
        }

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


