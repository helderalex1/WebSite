<?php

namespace frontend\controllers;

use common\models\Categoria;
use common\models\OrcamentoProduto;
use common\models\User;
use Yii;
use common\models\Orcamento;
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
                        'actions' => ['index', 'view', 'create','update','delete','addproduto', 'updateproduto','deleteproduto'],
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
        $model->getTotal();
        if( $model->getOwner() != Yii::$app->user->identity->getId()){
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

    public function actionAddproduto(){
            $orc_produto = new OrcamentoProduto();
            if ($orc_produto->load(Yii::$app->request->post()) && $orc_produto->save()) {
                Yii::$app->session->setFlash('success', "Produto inserido com sucesso");
                return $this->redirect(Yii::$app->request->referrer);
            }
            Yii::$app->session->setFlash('error', "Erro ao inserir! ( Verifique se o produto não se encontra já inserido )");
            return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUpdateproduto(){
        $post = Yii::$app->request->post();
        $post = $post["OrcamentoProduto"];
        $model = $this->findModel($post["orcamento_id"]);
        if( $model->getOwner() != Yii::$app->user->identity->getId()){
            throw new HttpException(403, Yii::t('app', 'You are not allowed to perform this action.'));
        }

        $model = OrcamentoProduto::find()->where(['orcamento_id' => $post["orcamento_id"], 'produto_id' => $post["produto_id"]])->one();
        $model->quantidade = $post["quantidade"];
        if ( $model->save()) {
            Yii::$app->session->setFlash('info', "Produto atualizado com sucesso");
            return $this->redirect(Yii::$app->request->referrer);
        }
        Yii::$app->session->setFlash('error', "Erro ao atualizar!");
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionDeleteproduto($id, $produto){
        $model = $this->findModel($id);
        if( $model->getOwner() != Yii::$app->user->identity->getId()){
            throw new HttpException(403, Yii::t('app', 'You are not allowed to perform this action.'));
        }
        $model = OrcamentoProduto::find()->where(['orcamento_id' => $id, 'produto_id' => $produto])->one();
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', "Produto removido com sucesso");
            return $this->redirect(Yii::$app->request->referrer);
        }
        Yii::$app->session->setFlash('error', "Erro ao remover!");
        return $this->redirect(Yii::$app->request->referrer);

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
