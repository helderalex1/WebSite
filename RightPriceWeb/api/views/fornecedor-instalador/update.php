<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FornecedorInstalador */

$this->title = 'Update Fornecedor Instalador: ' . $model->fornecedor_id;
$this->params['breadcrumbs'][] = ['label' => 'Fornecedor Instaladors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fornecedor_id, 'url' => ['view', 'fornecedor_id' => $model->fornecedor_id, 'instalador_id' => $model->instalador_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fornecedor-instalador-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
