<?php

namespace app\controllers;

use Yii;
use app\models\Obra;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ObraController implements the CRUD actions for Obra model.
 */
class ObraController extends ActiveController
{
    public $modelClass = 'app\models\Obra';
}
