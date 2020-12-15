<?php

namespace app\controllers;

use Yii;
use app\models\Categoria;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \GuzzleHttp\json_encode;

/**
 * CategoriaController implements the CRUD actions for Categoria model.
 */
class CategoriaController extends ActiveController
{
    public $modelClass = 'app\models\Categoria';


    //função que vai buscar as categorias para o sistema de login
    public function actionCategoria(){
        $catemodel= new $this->modelClass;

        $categorias= $catemodel::find()->asArray()->all();
        return json_encode($categorias);
    }



}
