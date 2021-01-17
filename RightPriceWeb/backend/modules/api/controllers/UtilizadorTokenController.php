<?php

namespace app\modules\api\controllers;

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
            throw new \yii\web\BadRequestHttpException("Error method you only have permissions to do get method");
        }

        $User = new $this->modelClass;
        $List_User = $User::find()->select('id,username,nome,nome_empresa,telemovel,email,imagem,categoria_id,status')->asArray()->all();

        if ($List_User){
            return $List_User;
        }
        return ["sucesso"=>"false","texto"=>"Sem Utilizadores no sistema"];;

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
            throw new \yii\web\BadRequestHttpException("Error method you only have permissions to do get method");
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
            return $queryResult;
        }
        return ["sucesso"=>"false","texto"=>"Sem Instaladores no sistema"];;
    }


    //funcao para carregar os utilizadores(so os fornecedores) para o instalador
    //retorna os fornecedores do sistema
    public function actionUserFornecedor(){
        $request = Yii::$app->request;
        if (!$request->isGet)
        {
            Yii::$app->response->statusCode = 400;
            throw new \yii\web\BadRequestHttpException("Error method you only have permissions to do get method");
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
            return $queryResult;
        }
        return ["sucesso"=>"false","texto"=>"Sem Fornecedores no sistema"];;

    }

}
