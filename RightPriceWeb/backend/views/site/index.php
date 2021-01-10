<?php

/* @var $this yii\web\View */

use common\models\User;

$this->title = 'My Yii Application';
$user = User::find()->where(['id'=> Yii::$app->user->identity->getId()])->one();
$role = \Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->getId());
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Bem-Vindo <?=$user['username'] ?> !</h1>

        <p class="lead">Aqui estão alguma estatísticas da aplicação.</p>

    </div>

    <div class="body-content">

        <?php if(isset($role['admin'])){ ?>
            <div class="row border border-dark shadow p-3">
                <div class="col text-center">
                    Numero de Instaladores:
                    <h1><?=count($user->getInstaladores()) ?></h1>
                </div>
                <div class="col text-center border-left border-dark ">
                    Numero de Fornecedor:
                    <h1><?=count($user->getFornecedores()) ?></h1>
                </div>


            </div>

            <h2 class="text-center mt-5">Numero de clientes por categoria:</h2>

            <div class="row text-center mt-5 mb-5 shadow p-3">
                <div class="col ">
                    <table class="table ">
                        <thead>
                        <tr>
                            <th scope="col">Categoria</th>
                            <th scope="col">Numero Clientes</th>
                        </tr>
                        </thead>

                        <?php foreach($user->getClientesByCategoria() as $categoria){ ?>
                            <tr>
                                <td><?=$categoria['categoria'] ?></td>
                                <td><?=$categoria['numClientes'] ?> </td>
                            </tr>


                        <?php }?>
                    </table>

                </div>
            </div>

        <?php } ?>

    </div>
</div>
