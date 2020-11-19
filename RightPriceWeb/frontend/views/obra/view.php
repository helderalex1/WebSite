<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Obra */
$cliente = $model->getCliente()->asArray()->all();
$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['/cliente']];
$this->params['breadcrumbs'][] = ['label' => $cliente[0]['nome'] , 'url' => ['/cliente/view', 'id'=> $cliente[0]['id']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="obra-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row mb-5">
        <div class="col">
            <p>
                <a class="btn btn-primary flex-center" href="#" data-toggle="modal" data-target="#updateObra">Update</a>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
        <div class="col text-right">
            <a class="btn btn-info flex-center" href="#" data-toggle="modal" data-target="#criarOrcamento">Adicionar Orçamento</a>
        </div>
    </div>



    <!-- ESTATISTICAS DA OBRA -->
    <div class="row justify-content-center">
        <div class="col "></div>
        <div class="col "></div>
        <div class="col "></div>
    </div>

</div>


<div class="modal fade" id="updateObra" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Atualizar Obra</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="container">
                <?php $form = ActiveForm::begin(['action' => ['update', 'id' => $model->id], 'method' => 'post']); ?>

                <?= $form->field($model, 'nome') ?>
                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="criarOrcamento" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Orçamento</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="container">
                <?php $form = ActiveForm::begin(['action' => '/orcamento/create', 'method' => 'post']); ?>

                <?= $form->field($orcamento, 'obra_id')->hiddenInput(['value'=>''.$model->id.''])->label(false); ?>

                <?= $form->field($orcamento, 'margem')->textInput() ?>

                <?= $form->field($orcamento, 'nome')->textInput(['maxlength' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>

