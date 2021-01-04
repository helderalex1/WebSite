<?php

use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ucfirst(Yii::$app->user->identity->username);
$this->params['breadcrumbs'][] = $this->title;
$user = User::find()->where(['id'=> Yii::$app->user->identity->getId()])->one();
$role = \Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->getId());
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if(isset($role['fornecedor'])){ ?>
        <p>Fornecedor</p>

        <div class="row">
            <div class="col text-center">
                Produtos Disponiveis:
                <h1><?=count($user->getProdutosArray()) ?></h1>
            </div>
            <div class="col text-center">
                Produtos Usados em encomendas:
                <h1><?=count($user->getProdutosUsadosArray()) ?></h1>
            </div>

            <div class="col text-center">
                Total encomendado:
                <h1><?=$user->getTotalOrcamentado()?> €</h1>
            </div>

        </div>
        <div class="row mt-5">
            <div class="col text-center">
                <p>Detalhes de produtos usados em encomendas:</p>
                <table class="table ">
                    <thead>
                    <tr>
                        <th scope="col">Referência</th>
                        <th scope="col">Preço un.</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Total</th>
                    </tr>
                    </thead>

                    <?php foreach($user->getTotalProdutos() as $produto){ ?>
                        <tr>
                            <td><?=$produto['produto'] ?></td>
                            <td><?=$produto['preco'] ?> €</td>
                            <td><?=$produto['quantidade'] ?></td>
                            <td><?=$produto['total'] ?> € </td>
                        </tr>


                    <?php }?>
                </table>

            </div>
        </div>

    <?php } ?>


    <?php if(isset($role['instalador'])){ ?>
        <p>Instalador</p>

    <?php } ?>





</div>
