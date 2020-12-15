<?php

namespace app\controllers;

use Yii;
use app\models\Orcamento;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrcamentoController implements the CRUD actions for Orcamento model.
 */
class OrcamentoController extends ActiveController
{
    public $modelClass = 'app\models\orcamento';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'tokenParam' => 'auth_key',
        ];
        return $behaviors;
    }


    //função que vai buscar os orcamnetos
    public function actionOrcamento(){
        $catemodel= new $this->modelClass;

        $prcamentos= $catemodel::find()->asArray()->all();
        return json_encode($prcamentos);
    }

}
