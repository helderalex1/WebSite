<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Orcamento */


$cliente = $model->getCliente()->asArray()->all();
$this->title = $model['nome'];

$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['/cliente']];
$this->params['breadcrumbs'][] = ['label' => $cliente[0]['nome'] , 'url' => ['/cliente/view', 'id'=> $cliente[0]['id']]];
$this->params['breadcrumbs'][] = $model['nome'];
\yii\web\YiiAsset::register($this);
?>
<div class="orcamento-view">

    <div class="row align-items-center">
        <div class="col-md-6 text-center">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
        <div class="col-md-6">
            <p>Info</p>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'data_orcamento',
                    'margem',
                    'total',
                ],
            ]) ?>
        </div>

    </div>
    <div class="row justify-content-center mt-5">
        <div class="col-md-3 overflow-auto"  style="height: 25vh">
            Escolher Categoria:<br>
            <?php foreach ($categorias as $categoria){ ?>
                <a href="<?=Url::toRoute(['orcamento/view', 'id'=> $model->id, 'id_c' => $categoria['id']]) ?>"> <?=$categoria['nome_Categoria'] ?></a><br>
            <?php } ?>
        </div>
        <div class="col-md-3 overflow-auto"  style="height: 25vh">
            Escolher Fornecedores:<br>
            <?php if($fornecedores!=null){?>
                <?php foreach ($fornecedores as $fornecedor){ ?>
                    <a href="<?=Url::toRoute(['orcamento/view', 'id'=> $model->id, 'id_c' => $fornecedor['categoria_id'], 'id_f' => $fornecedor['id']]) ?>"> <?=$fornecedor['username'] ?></a>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="col-md-6 overflow-auto"  style="height: 25vh">
            <table class="table text-center p-0">
                <tbody>
                <?php  if($produtos!=null){?>
                    <?php foreach ($produtos as $produto){ ?>
                        <tr>
                            <td><?=$produto['referencia'] ?></td>
                            <td><?=$produto['nome'] ?></td>
                            <td><?=$produto['preco'] ?></td>
                            <td class="p-2"><a href="" class="btn btn-success">+</a></td>
                        </tr>
                    <?php }
                }?>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped text-center p-0">
                <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="p-2"><a href="" class="btn btn-primary">Visualizar</a></td>
                </tr>
            </table>
        </div>

    </div>



</div>
