<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FornecedorInstalador */

$this->title = 'Create Fornecedor Instalador';
$this->params['breadcrumbs'][] = ['label' => 'Fornecedor Instaladors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fornecedor-instalador-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
