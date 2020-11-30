<?php

namespace backend\controllers;

use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = Yii::$app->request->post();
        if(!empty($model) && $model['username']!=''){
            return $this->render('index', [
                'users' => User::find()->where(['LIKE','username',$model['username']])->asArray()->all(),
            ]);
        }
        return $this->render('index', [
            'users' => User::find()->asArray()->all(),
        ]);
    }





    public function actionValidate($id)
    {
        $user = $this->findModel($id);
        if($user->status!= 10){
            $user->status =10;
        }else{
            $user->status =0;
        }
        $user->save();
        return $this->redirect(['user/index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
