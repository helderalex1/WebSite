<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FornecedorInstalador */

$this->title = $model->fornecedor_id;
$this->params['breadcrumbs'][] = ['label' => 'Fornecedor Instaladors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fornecedor-instalador-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'fornecedor_id' => $model->fornecedor_id, 'instalador_id' => $model->instalador_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'fornecedor_id' => $model->fornecedor_id, 'instalador_id' => $model->instalador_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fornecedor_id',
            'instalador_id',
            'created_at',
        ],
    ]) ?>

</div>
