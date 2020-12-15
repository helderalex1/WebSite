<?php

use yii\bootstrap4\ActiveForm;
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
<style>
    .form-group {
        margin-bottom: 0px;
    }
</style>
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
                                <?php $form = ActiveForm::begin(['action' => 'addproduto', 'method' => 'post']); ?>
                                <?=$form->field($orc_produto, 'orcamento_id')->hiddenInput(['value'=>''.$model->id.''])->label(false); ?>
                                <?=$form->field($orc_produto, 'produto_id')->hiddenInput(['value'=>''.$produto['id'].''])->label(false); ?>
                                <td><?=$produto['referencia'] ?></td>
                                <td><?=$produto['nome'] ?></td>
                                <td><?=$produto['preco'] ?></td>
                                <td><?= $form->field($orc_produto, 'quantidade',['options' => ['class' => 'form-group']] )->input('number', ['value' => 1,'min' => 0, 'max' => 100, 'step' => 1,'style'=>'margin-bottom: 0px;'])->label(false);?></td>
                                <td><?= Html::submitButton('+', ['class' => 'btn btn-primary']) ?></a></td>
                                <?php ActiveForm::end(); ?>
                            </tr>
                        <?php }
                    }?>

                </tbody>
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
