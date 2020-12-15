<?php

namespace app\controllers;

use yii\db\Query;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii;
use yii\helpers\Json;


/**
 * FornecedorInstaladorController implements the CRUD actions for FornecedorInstalador model.
 */
class FornecedorInstaladorController extends ActiveController
{
    public $modelClass = 'app\models\fornecedorinstalador';

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
    public function actionForne($id)
    {

        $request = Yii::$app->request;
        if (!$request->isGet)
        {
            Yii::$app->response->statusCode = 400;
            die();
        }

        $forne_instal = new $this->modelClass;
        $fornecedor = $forne_instal::find()->select('fornecedor_id,instalador_id')->where(["fornecedor_id"=>$id])->asArray()->all();
        if ($fornecedor){
            return json_encode($fornecedor);
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
   public function actionInsta($id){
       $request = Yii::$app->request;
       if (!$request->isGet)
       {
           Yii::$app->response->statusCode = 400;
           die();
       }

       $insta_forne = new $this->modelClass;
       $instaladores= $insta_forne::find()->select('fornecedor_id,instalador_id')->where(["instalador_id"=>$id])->asArray()->all();
       if ($instaladores){
           return json_encode($instaladores);
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



/*    //Mostrar fornecedores da mesma categoria do instalador
    public function actionConhecerforne($id)
    {
        $query = new Query;
        $script = ($query
            ->select('u1.*')
            ->from('user u')
            ->innerJoin('fornecedor_instalador fi','fi.fornecedor_id = u.id')
            ->innerJoin('user u1','u1.id = fi.instalador_id ')
            ->where('u.id='.$id.' AND u.categoria_id <=> u1.categoria_id'))
            ->createCommand();
        $queryResult = $script->query();
        return $queryResult;
    }
    //Mostrar instaladores da mesma categoria do fornecedor
    public function actionConhecerinsta($id)
    {
        $query = new Query;
        $script = ($query
            ->select('u1.*')
            ->from('fornecedor_instalador fi')
            ->innerJoin('user u','u.id = fi.instalador_id ')
            ->innerJoin('user u1','fi.fornecedor_id = u1.id')
            ->where('u.id='.$id.' AND u.categoria_id <=> u1.categoria_id'))
            ->createCommand();
        $queryResult = $script->query();
        return $queryResult;
    }

*/


