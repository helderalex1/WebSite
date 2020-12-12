<?php

namespace app\controllers;

use Yii;
use app\models\Cliente;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClienteController implements the CRUD actions for Cliente model.
 */
class ClienteController extends ActiveController
{
    public $modelClass = 'app\models\Cliente';
}
