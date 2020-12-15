<?php

namespace frontend\controllers;

use app\models\Categoria;
use app\models\OrcamentoProduto;
use app\models\User;
use Yii;
use app\models\Orcamento;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
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
                        'actions' => ['index', 'view', 'create','update','delete','addproduto'],
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
        $model = $this->findModel($id);
        $orcamento = Orcamento::findOne($id);

        $model->getTotal();
        if( $orcamento->getOwner() != Yii::$app->user->identity->getId()){
            throw new HttpException(403, Yii::t('app', 'You are not allowed to perform this action.'));
        }
        $user = User::findOne(Yii::$app->user->identity->getId());

        $orc_produto = new OrcamentoProduto();
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
            'model' => $model,
            'categorias' => $categorias,
            'fornecedores' => $fornecedores,
            'produtos' =>$produtos ,
            'orc_produto' => $orc_produto
        ]);
    }

    public function actionAddproduto(){
        $orc_produto = new OrcamentoProduto();
        if ($orc_produto->load(Yii::$app->request->post()) && $orc_produto->save()) {
            Yii::$app->session->setFlash('success', "Produto inserido com sucesso");
            return $this->redirect(Yii::$app->request->referrer);
        }
        Yii::$app->session->setFlash('error', "Erro ao inserir! ( Verifique se o produto não se encontra já inserido )");
        return $this->redirect(Yii::$app->request->referrer);
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
