<?php

use yii\bootstrap4\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cliente */
$orcamentos =  $model->getOcamentos()->asArray()->all();

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cliente-view">
    <h1>Cliente: <?= Html::encode($this->title) ?></h1>
    <div class="row mb-5">
        <div class="col">
            <a class="btn btn-primary flex-center" href="#" data-toggle="modal" data-target="#updateCliente">Update</a>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <div class="col text-right">
            <a class="btn btn-success flex-center" href="#" data-toggle="modal" data-target="#adicionarOrcamento">Adicionar Orçamento</a>
        </div>
    </div>

    <div class="row justify-content-center">

        <div class="col-md-4">
            <p>Info</p>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'nome',
                    'Telemovel',
                    'Nif',
                    'Email:email',
                ],
            ]) ?>
        </div>
        <div class="col-md-8 ">
            <p>Orçamentos</p>
            <table class="table table-striped text-center p-0">
                <tbody>
                <?php for( $i= 0 ; $i<$model->getOcamentos()->count(); $i++){?>
                    <tr>
                        <td><?=$orcamentos[$i]['id'] ?></td>
                        <td><?=$orcamentos[$i]['nome'] ?></td>
                        <td class="p-2"><a href="<?=Url::toRoute(['orcamento/view', 'id' => $orcamentos[$i]['id'] ]) ?>" class="btn btn-primary">Visualizar</a></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" id="adicionarOrcamento" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Orcamento</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="container">
                <?php $form = ActiveForm::begin(['action' => ['/orcamento/create'], 'method' => 'post']); ?>

                <?= $form->field($orcamento, 'cliente_id')->hiddenInput(['value'=>''.$model->id.''])->label(false); ?>

                <?= $form->field($orcamento, 'nome') ?>
                <?= $form->field($orcamento, 'margem')->input('number', ['min' => 0, 'max' => 102, 'step' => 1])?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="updateCliente" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Cliente</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="container">
                <?php $form = ActiveForm::begin(['action' => ['cliente/update', 'id'=>$model['id']], 'method' => 'post']); ?>

                <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'Telemovel')->textInput() ?>

                <?= $form->field($model, 'Nif')->textInput() ?>

                <?= $form->field($model, 'Email')->textInput(['maxlength' => true]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

