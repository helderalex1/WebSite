<?php

namespace frontend\controllers;

use common\models\User;
use Yii;
use common\models\Produto;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProdutoController implements the CRUD actions for Produto model.
 */
class ProdutoController extends Controller
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
                        'roles' => ['fornecedor'],
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
     * Lists all Produto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $user = User::findOne(Yii::$app->user->identity->getId());

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM produto WHERE fornecedor_id='.Yii::$app->user->identity->getId() ,
            'params' => [':status' => 1],
            'totalCount' => $user->getProdutos()->count(),
            'sort' => [
                'attributes' => [
                    'age',
                    'name' => [
                        'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                        'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Produto model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Produto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Produto();
        $model->fornecedor_id = Yii::$app->user->identity->getId();
        if ($model->load(Yii::$app->request->post()) ) {
            $imagem = UploadedFile::getInstance($model, 'imagem');
            if($imagem == '' || $imagem->extension != 'png' && $imagem->extension != 'jpg' ){
                Yii::$app->session->setFlash('error', "Erro ao inserir! ( Imagem Inválida )");
                return $this->render('create', ['model' => $model,]);
            }
            $unique_name = uniqid('file_');
            $model->imagem = 'uploads/'.$unique_name .'.'. $imagem->extension;
            if ($model->save()  ) {
                $imagem->saveAs('uploads/'.$unique_name.'.'.$imagem->extension);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Produto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->fornecedor_id = Yii::$app->user->identity->getId();
        if ($model->load(Yii::$app->request->post())) {
            $imagem = UploadedFile::getInstance($model, 'imagem');
            if($imagem != ''){
                if($imagem->extension != 'png' && $imagem->extension != 'jpg' ){
                    Yii::$app->session->setFlash('error', "Erro ao inserir! (Imagem Inválida)");
                    return $this->render('create', ['model' => $model,]);
                }
                if(isset($model->imagem)){
                    unlink($model->imagem);
                }
                $unique_name = uniqid('produto_');
                $model->imagem = 'uploads/'.$unique_name .'.'. $imagem->extension;
                $imagem->saveAs('uploads/'.$unique_name.'.'.$imagem->extension);
            }

            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Produto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Produto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Produto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Produto::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
