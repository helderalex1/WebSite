<?php

namespace app\modules\api\controllers;


use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;



/**
 * ClienteController implements the CRUD actions for Cliente model.
 */
class ClienteController extends ActiveController
{

    public $modelClass = 'common\models\Cliente';
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



    //Mostrar os clientes desse instalador
    //retorna os cliente dos instaladores
    //id é o id do instalador
    public function actionClientesInstalador($id_instalador)
    {
        $request = Yii::$app->request;
        if (!$request->isGet) {
            Yii::$app->response->statusCode = 400;
            throw new \yii\web\BadRequestHttpException("Error method you only have permissions to do get method");
        }

        $ModelAuth_Assignment = new $this->modelAuthAssigment ();
        $InstaladorExiste = $ModelAuth_Assignment::find()->where(["user_id" => $id_instalador])->one();

        if ($InstaladorExiste) {
            if (strcmp($InstaladorExiste->item_name, "instalador")==0) {
                $clientes_insta = new $this->modelClass;
                $List_clientes = $clientes_insta::find()->select('id,user_id,nome,Telemovel,Nif,Email')->where(["user_id" => $id_instalador])->asArray()->all();
                if ($List_clientes) {
                    return $List_clientes;
                } else {
                    return ["sucesso" => "false", "texto" => "Sem clientes"];
                }
            } else {
                throw new \yii\web\NotFoundHttpException("Installer id not found or didn't exist!");
            }
        }else{
            throw new \yii\web\NotFoundHttpException("Installer id not found or didn't exist!");
        }
    }
}
