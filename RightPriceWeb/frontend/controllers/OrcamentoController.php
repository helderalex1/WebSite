<?php

namespace frontend\controllers;

use app\models\Categoria;
use app\models\User;
use Yii;
use app\models\Orcamento;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrcamentoController implements the CRUD actions for Orcamento model.
 */
class OrcamentoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create','update','delete'],
                        'roles' => ['instalador'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Displays a single Orcamento model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $id_c=null, $id_f=null)
    {
        $user = User::findOne(Yii::$app->user->identity->getId());
        $fornecedores = null;
        $categorias = Categoria::find()->asArray()->all();
        $produtos = null;
        if($id_c !=null)
        {
            $fornecedores = $user->getFornecedors();
            $fornecedores = $fornecedores->where(['categoria_id' => $id_c])->asArray()->all();
        }
        if($id_f !=null){
            $fornecedor = User::findOne($id_f);
            $produtos= $fornecedor->getProdutos()->asArray()->all();
        }


        return $this->render('view', [
            'model' => $this->findModel($id),
            'categorias' => $categorias,
            'fornecedores' => $fornecedores,
            'produtos' =>$produtos
        ]);
    }

    /**
     * Creates a new Orcamento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orcamento();
        $model->data_orcamento = date('Y-m-d');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Orcamento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Orcamento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['cliente']);
    }

    /**
     * Finds the Orcamento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orcamento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orcamento::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
