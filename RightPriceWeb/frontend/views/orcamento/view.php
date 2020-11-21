<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Orcamento */


$obra = $model->getObra()->asArray()->all();
$cliente = \app\models\Cliente::findOne($obra[0]['cliente_id']);
$this->title = $model['nome'];

$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['/cliente']];
$this->params['breadcrumbs'][] = ['label' => $cliente['nome'] , 'url' => ['/cliente/view', 'id'=> $cliente['id']]];
$this->params['breadcrumbs'][] = ['label' => $obra[0]['nome'] , 'url' => ['/obra/view', 'id'=> $obra[0]['id']]];;
$this->params['breadcrumbs'][] = $model['nome'];
\yii\web\YiiAsset::register($this);
?>
<div class="orcamento-view">

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'obra_id',
            'data_orcamento',
            'margem',
            'total',
            'nome',
        ],
    ]) ?>

</div>
