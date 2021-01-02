<?php

namespace app\modules\api\controllers;

use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use Yii;
use yii\db\Query;


class AuthAssigmentController extends ActiveController
{
    public $modelClass = 'common\models\AuthAssignment';

     public function behaviors()
     {
         $behaviors = parent::behaviors();
         $behaviors['authenticator'] = [
             'class' => QueryParamAuth::className(),
             'tokenParam' => 'auth_key',
         ];
         return $behaviors;
     }



     //funcao para carregar as atribuiçoes de cada utilizador
    public function actionAuth()
    {
        $request = Yii::$app->request;
        if (!$request->isGet)
        {
            Yii::$app->response->statusCode = 400;
            throw new \yii\web\BadRequestHttpException("Error method you only have permissions to do get method");
        }

        $Auth = new $this->modelClass;
        $List_Auth = $Auth::find()->select('item_name,user_id')->asArray()->all();

        if ($List_Auth){
            return $List_Auth;
        }
        return ["sucesso"=>"false","texto"=>"Sem funcoes atribuidas"];;

    }

}
