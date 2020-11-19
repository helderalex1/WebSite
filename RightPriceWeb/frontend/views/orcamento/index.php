<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orcamentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orcamento-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Orcamento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'obra_id',
            'data_orcamento',
            'margem',
            'total',
            //'nome',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
