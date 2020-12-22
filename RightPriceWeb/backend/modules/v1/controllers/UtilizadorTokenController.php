<?php

namespace app\modules\v1\controllers;

use yii\filters\auth\QueryParamAuth;
use yii\helpers\Json;
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


    public function actionUserInstalador(){

    }

    public function actionUserFornecedor(){

    }


}
