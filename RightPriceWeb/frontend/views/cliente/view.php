<?php

use app\models\Obra;
use yii\bootstrap4\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cliente */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$obras = $model->getObras()->asArray()->all();
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
            <p>Obras</p>
            <table class="table table-striped text-center">
                <tbody>
                <?php for( $i= 0 ; $i<$model->getObras()->count(); $i++){?>
                    <tr>
                        <td><?=$obras[$i]['id'] ?></td>
                        <td><?=$obras[$i]['nome'] ?></td>
                        <td><a href="#" class="btn btn-primary">Visualizar</a></td>
                    </tr>
                <?php } ?>
            </table>
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
            <div class="container">


                <?php $form = ActiveForm::begin(['action' => ['obra/create'], 'method' => 'post']); ?>

                <?= $form->field($obra, 'cliente_id')->hiddenInput(['value'=>''.$model->id.''])->label(false); ?>

                <?= $form->field($obra, 'nome') ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>
