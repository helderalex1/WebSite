<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$categorias = \app\models\Categoria::find()->asArray()->all();

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1>Gestor de Registos</h1>

    <div class="row mt-5">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(['action' => ['user/index'], 'method' => 'post']); ?>
            <div class="form-group">
                Procurar por username:
                <input type="text" name="username">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
            </div>
            <div class="form-group">
            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>

    <table class="table mt-5">
        <thead>
        <tr>
            <th scope="col">Username</th>
            <th scope="col">Nome Completo</th>
            <th scope="col">email</th>
            <th scope="col">Categoria</th>
            <th scope="col">Tipo de utilizador</th>
            <th scope="col">Status</th>
            <th scope="col">Opções</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user){?>
            <tr>
                <th scope="row"><?=$user['username']?></th>
                <td><?=$user['nome']?></td>
                <td><?=$user['email']?></td>
                <td><?php foreach ($categorias as $categoria){
                        if($categoria['id'] == $user['categoria_id']){
                            echo $categoria['nome_Categoria'];
                        }
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $role=\Yii::$app->authManager->getRolesByUser($user['id']);
                    if(isset($role['fornecedor'])){
                        echo 'Fornecedor';
                    }else{
                        echo 'Instalador';
                    }
                    ?>
                </td>
                <td>
                    <?php

                    if($user['status']==9){
                        echo 'Novo';
                    }elseif($user['status']==0){
                        echo 'Bloqueado';
                    }else{
                        echo 'Ativo';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if($user['status']!=10){
                        echo Html::a('Permitir', ['validate', 'id' => $user['id']], ['class' => 'btn btn-success']);
                    }else{
                        echo Html::a('Bloquear', ['validate', 'id' => $user['id']], ['class' => 'btn btn-danger']);
                    }
                    ?>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>
