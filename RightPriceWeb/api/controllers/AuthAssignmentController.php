<?php

namespace app\controllers;

use Yii;
use app\models\AuthAssignment;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuthAssignmentController implements the CRUD actions for AuthAssignment model.
 */
class AuthAssignmentController extends ActiveController
{
    public $modelClass = 'app\models\AuthAssignment';
}
