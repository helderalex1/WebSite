<?php

namespace app\modules\v1\controllers;

use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use Yii;
use yii\db\Query;


class UtilizadorTokenController extends ActiveController
{
    public $modelClass = 'common\models\User';

     public function behaviors()
     {
         $behaviors = parent::behaviors();
         $behaviors['authenticator'] = [
             'class' => QueryParamAuth::className(),
             'tokenParam' => 'auth_key',
         ];
         return $behaviors;
     }



     //funcao para carregar os utilizadores para o admin
    //retorna todos os utilizadores do sistema
    public function actionUser()
    {
        $request = Yii::$app->request;
        if (!$request->isGet)
        {
            Yii::$app->response->statusCode = 400;
            die();
        }

        $User = new $this->modelClass;
        $List_User = $User::find()->select('id,username,nome,nome_empresa,telemovel,email,imagem,categoria_id,status')->asArray()->all();

        if ($List_User){
            return json_encode($List_User);
        }
        return json_encode("NUll");

                                       /* $query = new Query;
                                        $script = ($query
                                            ->select('u.id,u.username,u.nome,u.nome_empresa,u.telemovel,u.email,u.imagem,u.categoria_id,u.status')
                                            ->from('user u'))
                                            ->createCommand();
                                        $queryResult = $script->query();

                                        if($queryResult)
                                            return $queryResult;
                                        return json_encode("NUll");*/
    }


    //funcao para carregar os utilizadores (só os instaladores) para o fornecedor
    //retorna os instaladores
    public function actionUserInstalador(){
        $request = Yii::$app->request;
        if (!$request->isGet)
        {
            Yii::$app->response->statusCode = 400;
            die();
        }

        $query = new Query;
        $script = ($query
            ->select('u.id,u.username,u.nome,u.nome_empresa,u.telemovel,u.email,u.imagem,u.categoria_id,u.status')
            ->from('user u')
            ->innerJoin('auth_assignment aut','aut.user_id = u.id ')
            ->where('aut.item_name= "instalador"'))
            ->createCommand();
        $queryResult = $script->queryAll();

        if ($queryResult){
            return json_encode($queryResult);
        }
        return json_encode("NUll");
    }


    //funcao para carregar os utilizadores(so os fornecedores) para o instalador
    //retorna os fornecedores do sistema
    public function actionUserFornecedor(){
        $request = Yii::$app->request;
        if (!$request->isGet)
        {
            Yii::$app->response->statusCode = 400;
            die();
        }

        $query = new Query;
        $script = ($query
            ->select('u.id,u.username,u.nome,u.nome_empresa,u.telemovel,u.email,u.imagem,u.categoria_id,u.status')
            ->from('user u')
            ->innerJoin('auth_assignment aut','aut.user_id = u.id ')
            ->where('aut.item_name= "fornecedor"'))
            ->createCommand();
        $queryResult = $script->queryAll();

        if ($queryResult){
            return json_encode($queryResult);
        }
        return json_encode("NUll");

    }


}
