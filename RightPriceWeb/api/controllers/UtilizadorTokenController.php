<?php

namespace app\controllers;

use yii\filters\auth\QueryParamAuth;
use yii\helpers\Json;
use yii\rest\ActiveController;

class UtilizadorTokenController extends ActiveController
{
    public $modelClass = 'app\models\User';

   /* public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }*/


    public function actionNome ($id)
    {
        $climodel = new $this->modelClass;
        $ret = $climodel::find()->where("id=" . $id)->one();
        if ($ret)
            return ['id' => $id, 'Nome' => $ret->Nome];
        return ['id' => $id, 'Nome' => "null"];
    }

    public function actionUserPendentes()
    {
        $climodel = new $this->modelClass;

        $rec = $climodel::find()->where(["Status"=>'9'])->all();
        if($rec)
            return Json::encode($rec);
        return ['null'];
    }

}
