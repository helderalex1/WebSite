<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cliente */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cliente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row mb-5">
        <div class="col">
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <div class="col text-right">
            <a class="btn btn-success flex-center" href="#" data-toggle="modal" data-target="#adicionarObra">Adicionar Obra</a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-4">
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
        <div class="col-md-8">


        </div>
    </div>
</div>
</div>


<div class="modal fade" id="adicionarObra" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Obra</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="container-fluid">
                <form method="POST" action="#">
                    <input type="hidden" name="cliente_id" value="{{$cliente->id}}">
                    <div class="form-group mt-2">
                        <label for="nome">Nome:</label>
                        <input id="nome" name="nome" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" >Inserir</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
