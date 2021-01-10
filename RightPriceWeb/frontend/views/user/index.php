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

    <div class="jumbotron mt-5">
        <h1>Bem-Vindo <?=$user['username'] ?> !</h1>

        <p class="lead">Aqui estão alguma estatísticas da sua conta.</p>

    </div>

    <?php if(isset($role['fornecedor'])){ ?>
        <p class="text-center mb-5">Fornecedor</p>

        <div class="row border border-dark shadow p-3">
            <div class="col text-center">
                Produtos Disponiveis:
                <h1><?=count($user->getProdutosArray()) ?></h1>
            </div>
            <div class="col text-center border-right border-left border-dark">
                Produtos Usados em encomendas:
                <h1><?=count($user->getProdutosUsadosArray()) ?></h1>
            </div>

            <div class="col text-center">
                Total encomendado:
                <h1><?=$user->getTotalEncomendado()?> €</h1>
            </div>

        </div>
        <h2 class="text-center mt-5">Detalhes de produtos usados em encomendas:</h2>
        <div class="row ">
            <div class="col text-center mt-5 mb-5 shadow p-3">
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
        <p class="text-center mb-5"> Instalador</p>

        <div class="row border border-dark shadow p-3">
            <div class="col text-center">
                Numero de Clientes:
                <h1><?=count($user->getClientesArray()) ?></h1>
            </div>
            <div class="col text-center border-right border-left border-dark ">
                Numero de Orçamentos:
                <h1><?=$user->getNumeroOrcamentos() ?></h1>
            </div>

            <div class="col text-center">
                Total encomendado:
                <h1><?=$user->getTotalOrcamentado()?> €</h1>
            </div>

        </div>

        <h2 class="text-center mt-5">Detalhes de clientes:</h2>

        <div class="row text-center mt-5 mb-5 shadow p-3">
            <div class="col ">
                <table class="table ">
                    <thead>
                    <tr>
                        <th scope="col">Cliente</th>
                        <th scope="col">Num. Orçamentos</th>
                        <th scope="col">Total €</th>
                    </tr>
                    </thead>

                    <?php foreach($user->getTotalOrcamentadoClientes() as $produto){ ?>
                        <tr>
                            <td><?=$produto['cliente'] ?></td>
                            <td><?=$produto['numero_orcamentos'] ?> </td>
                            <td><?=$produto['total'] ?> € </td>
                        </tr>


                    <?php }?>
                </table>

            </div>
        </div>

    <?php } ?>





</div>
